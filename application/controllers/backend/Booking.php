<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('BOOKING_STATUS_CANCELLED', 0);
define('BOOKING_STATUS_TENTATIVE', 1);
define('BOOKING_STATUS_COMPLETED', 2);
define('BOOKING_STATUS_CONFIRMED', 3);


class Booking extends TF_Controller {

	public function index()
	{
		if (!$_POST) return;

		$booking_id = (int)$this->input->get_post('id');
		$guest_id = (int)$this->input->get_post('guest_id');
        $original_status = (int)$this->input->get_post('original_status');
        $personalized = (int)$this->input->get_post('personalized');
        $room_id = (int)$this->input->get_post('room_id');
		$status = $this->input->get_post('status');
		$package_id = (int)$this->input->get_post('package_id');
        $data = array(
			'title' => $this->input->get_post('title'),
			'package_id' => $personalized === 0 ? $package_id : 0,
			'status' => $status,
			'guest_id' => $guest_id,
			'fax' => (int)$this->input->get_post('fax'),
            'personalized' => $personalized,
            'room_id' => $room_id,
            'restrictions' => $this->input->get_post('restrictions'),
		);

		if ($this->input->get_post('start_date')) {
			$data['start_date'] = strtotime($this->input->get_post('start_date'));
            $start_date = $data['start_date'];
		}

		if ($this->input->get_post('end_date')) {
			$data['end_date'] = strtotime($this->input->get_post('end_date'));
            $end_date = $data['end_date'];
        }

		if ($notes = $this->input->get_post('notes')) {
			$data['notes'] = $notes;
		}

		$query = $this->db->get_where('contacts', 'contact_id = '.$guest_id);
		$guest = $query->row_array();
		
		if (current_user_can('can_manage_guest_bookings')) {
		
			if ($booking_id)
			{
				$notify = false;
				$subject = '';
				$message = '';
	
				if ($original_status !== 'confirmed' && $data['status'] === 'confirmed') {
					$subject = 'Booking Confirmation';
					$message = 'Hi '.$guest['first_name'].", \n\n\n".
						'This is to confirm your booking. '."\n\n".
						'Program : '.$data['title']."\n".
						'Date : '.date('m/d/Y', $data['start_date']).' - '.date('m/d/Y', $data['end_date'])."\n\n".
						'Please login to your account to view your booking.'."\n\n".
						site_url();
					$notify = true;
				}
	
				if ($original_status !== 'completed' && $data['status'] === 'completed') {
					$subject = 'Booking Completed';
					$message = 'Hi '.$guest['first_name'].", \n\n\n".
						'Thank you for booking with us. '."\n\n".
						site_url();
					$notify = true;
				}
	
				if ($notify) {
					$this->load->library('email');
					$this->email->from($this->session->userdata('email'),  $this->session->userdata('screen_name'));
					$this->email->to($guest['email']);
					$this->email->subject($subject);
					$this->email->message($message);
					$this->email->send();
					$this->db->insert('messages', array(
						'message' => $subject,
						'receiver' => $guest_id,
						'date_sent' => date('c', now()),
						'sender' => get_current_user_id(),
					));
				}
	
				$data['edit_date'] = now();
				$this->db->update('bookings', $data, array('booking_id' => $booking_id));
			}
			else {
				
	
				$data['entry_date'] = now();
				$data['author_id'] = get_current_user_id();
	
				$this->db->insert('bookings', $data);
				$booking_id = $this->db->insert_id();
	
				if (!isset($_REQUEST['skip_confirmation'])) {
	
					$this->load->library('email');
	
					$this->email->from($this->session->userdata('email'),  $this->session->userdata('screen_name'));
					$this->email->to($guest['email']);
	
					$this->email->subject('Booking');
					$this->email->message(
						'Hi '.$guest['first_name'].", \n\n\n".
						'Welcome to TheFarm. '."\n\n".
						'Please login to your account to verify your booking.'."\n\n".
						site_url('booking/verify/'.$booking_id)
					);
	
					$this->email->send();
				}
	
				//build message.
				$message = 'Welcome to TheFarm';
				$this->db->insert('messages', array(
					'message' => $message,
					'receiver' => $guest_id,
					'date_sent' => date('c', now()),
					'sender' => get_current_user_id(),
				));
			}
		

		
		
			$package_items = array();
			$this->db->select('item_id');
			$this->db->from('booking_items');
			$this->db->where('booking_id', $booking_id);
			$items = $this->db->get();
			if ($items->num_rows() > 0) {
				foreach ($items->result_array() as $row) {
					$package_items[] = $row['item_id'];
				}
			}
	
			if ($this->input->get_post('package_items')) {
				$exclude = array();
				foreach ($_POST['package_items'] as $id => $item) {				
					if ($id) {

					    $_item = get_item($item['item_id']);
											
						$included = isset($item['included']) ? 1 : 0;						
						$foc = isset($item['foc']) ? 1 : 0;
						$upsell = isset($item['upsell']) ? 1 : 0;
						$upgrade = isset($item['upgrade']) ? 1 : 0;
						$data = array(
							'booking_id' => $booking_id,
							'item_id' => (int)$item['item_id'],
							'quantity' => (int)$item['qty'],
							'included' => $included,
							'upsell' => $upsell,
							'foc' => $foc,
							'upgrade' => $upgrade);
						
						if (stripos($id, 'new') !== false) {
                            $data['inventory'] = $data['quantity'];
                            $this->db->insert('booking_items', $data);
                            $booking_item_id = $this->db->insert_id();
                            $exclude[] = $booking_item_id;
                            $facility_id = 0;
                            if ($_item['related_facilities']) {
                                $facility_id = $_item['related_facilities'][0]['facility_id'];
                            }
                            $query = $this->db->get_where('item_day_time_settings', array('item_id' => $item['item_id']));

                            if ($query->num_rows() > 0) {
                                $count = 0;

                                $booking_dates = createDateRangeArray(date('Y-m-d', $start_date), date('Y-m-d', $end_date));

                                foreach ($query->result_array() as $row) {
                                    $day_settings = explode(',', trim($row['day_settings']));
                                    $time_settings = explode(',', trim($row['time_settings']));
                                    if ($count === (int)$item['qty']) break;

                                    foreach ($booking_dates as $date) {

                                        if ($count === (int)$item['qty']) break;

                                        foreach ($time_settings as $tm) {
                                            if ($tm) {

                                                $_start_date = new DateTime($date . ' ' . $tm);
                                                $_end_date = new DateTime($date . ' ' . $tm);
                                                $_end_date->add(new DateInterval('PT' . $_item['duration'] . 'M'));
                                                $_day = $_start_date->format('D');

                                                if ($count === (int)$item['qty']) break;

                                                if (count($day_settings) === 0 || in_array($_day, $day_settings)) {
                                                    $calendar_data = array(
                                                        'start_dt' => $_start_date->format('Y-m-d H:i:s'),
                                                        'end_dt' => $_end_date->format('Y-m-d H:i:s'),
                                                        'entry_date' => now(),
                                                        'item_id' => $item['item_id'],
                                                        'booking_item_id' => $booking_item_id,
                                                        'status' => 'confirmed',
                                                        'facility_id' => $facility_id
                                                    );
                                                    $this->db->insert('booking_events', $calendar_data);
                                                    $count++;
                                                }
                                            }
                                        }

                                    }
                                }
                            }

						}
						else {
							$this->db->update('booking_items', $data, array('booking_item_id' => $id));
							$exclude[] = $id;
						}
					}
				}
				if ($exclude)
					$this->db->delete('booking_items', 'booking_id = '.$booking_id.' AND booking_item_id NOT IN('.implode(',', $exclude).')');
			}
		}
		
		$config = $this->db->get_where('upload_prefs', array('upload_id' => 1))->row_array();
		
		$this->load->library('upload', $config);

		if ($this->upload->do_upload('attachment')) {
			$file = $this->upload->data();
			$this->db->insert('files', array(
				'file_name' => $file['file_name'],
				'title' => $file['file_name'],
				'file_size' => $file['file_size'],
				'upload_date' => now(),
				'upload_id' => 1,
			));
			$file_id = $this->db->insert_id();
			$this->db->insert('booking_attachments', array('booking_id' => $booking_id, 'file_id' => $file_id));
		}
			
		
		if ($this->input->get_post('booking_forms'))
		{
			foreach ($_REQUEST['booking_forms'] as $id => $row) {
				$required = isset($row['required']) ? 'y' : 'n';
				$submitted = isset($row['submitted']) ? 'y' : 'n';
				$notify_users = isset($row['notify_user_on_submit']) ? serialize($row['notify_user_on_submit']) : '';
				
				$q = $this->db->get_where('booking_forms', sprintf('booking_id = %d AND form_id = %d', $booking_id, $id));
				if ($q->num_rows() === 0)			
					$this->db->insert('booking_forms', array(
						'booking_id' => $booking_id,
						'form_id' => $id,
						'required' => $required,
						'submitted' => $submitted,
						'notify_user_on_submit' => $notify_users));
				else
					$this->db->update('booking_forms', array(
						'required' => $required,
						'submitted' => $submitted,
						'notify_user_on_submit' => $notify_users),
						sprintf('booking_id = %d AND form_id = %d', $booking_id, $id));
			}
		}


		if ($status === 'confirmed') {
			redirect('backend/account/edit/'.$guest_id.'/'.$booking_id.'#appointment');
		}
		else {
			redirect('backend/account/edit/'.$guest_id.'#bookings');
		}
	}
	
	public function edit()
	{
		$this->load->helper('item');
		
		$data = array(
			'contact_id' => $this->uri->segment(4),
			'booking_id' => intval($this->uri->segment(5)),
			'start_date' => '',
			'end_date' => '',
			'title' => '',
			'notes' => '',
			'status' => '',
			'package_id' => 0,
			'fax' => 1,
            'personalized' => 0,
            'room_id' => 0,
            'restrictions' => '',
		);

		$query = $this->db->get_where('bookings', array('booking_id' => $data['booking_id']));

		if ($query->num_rows() > 0) {
			$booking_data = $query->row_array();
			$data = array_merge($data, $booking_data);
		}

		$data['personalized'] = (int)$data['personalized'];

		$data['packages'] = $this->db->get('packages')->result_array();
		
		$data['services'] = $this->db->get('items')->result_array();

		$statuses = array_merge(array('' => '-Select-'), get_statuses(1));
		$data['statuses'] = $statuses;

		$data['booking_items'] = booking_items($data['booking_id']);
		
		$this->db->select('*');
		$this->db->from('items');
		$this->db->join('item_categories', 'items.item_id = item_categories.item_id');
		$this->db->where('item_categories.category_id', 8);
		$this->db->order_by('items.title');
		$query = $this->db->get();
		$facilities = $query->result_array();
        $facilities_array = array(0 => 'None');

        foreach ($facilities as $row) {
            $facilities_array[$row['item_id']] = $row['title'];
        }
        
        $data['facilities'] = $facilities_array;
		
		$this->db->select('files.file_name, files.file_id, files.upload_date');
		$this->db->join('files', 'files.file_id = booking_attachments.file_id');
		$this->db->from('booking_attachments');
		$this->db->where('booking_attachments.booking_id', $data['booking_id']);
		
		$data['attachments'] = $this->db->get()->result_array();
		
		if ($data['booking_id']) {
			$this->db->select('forms.form_id, forms.form_name, booking_forms.required, booking_forms.submitted, booking_forms.notify_user_on_submit');
			$this->db->from('forms');
			$this->db->join('booking_forms', 'booking_forms.form_id = forms.form_id', 'left');
			$this->db->where('booking_forms.booking_id = ' . $data['booking_id']);
		}
		else {
			$this->db->select('forms.form_id, forms.form_name, "n" as required, "n" as submitted, "" as notify_user_on_submit');
			$this->db->from('forms');
		}

		$query = $this->db->get();
		
		$booking_forms = array();
		if ($query->num_rows() > 0) {
			$booking_forms = $query->result_array();
		}

		$notify_users = array();
		$notify_users[get_current_user_id()] = 'Me'; //get_service_providers();
		$notify_users = array_merge($notify_users, get_service_providers());
		
		$data['notify_users'] = $notify_users;
		$data['forms'] = $booking_forms;

		$this->load->view('admin/booking/edit', $data);
	}

	public function delete() {

		$id = (int)$this->uri->segment(4);
		$confirm = $this->input->get_post('confirm');
		if ($id && $confirm && $confirm === 'y') {

			//@TODO add verification.

			$this->db->delete('bookings', array('booking_id' => $id));
			$this->db->delete('booking_items', array('booking_id' => $id));
			$this->db->delete('booking_forms', array('booking_id' => $id));
			$this->db->delete('booking_attachments', array('booking_id' => $id));


			if ($return = $this->input->get_post('return'))
				redirect($return);
		}

		redirect('backend/services');
	}

	public function form() {
        $booking_id = (int)$this->uri->segment(4);
        $form_id = (int)$this->uri->segment(5);

        $data['booking_id'] = $booking_id;
        $data['form_id'] = $form_id;

        $this->db->from('forms');
        $this->db->join('booking_forms', 'booking_forms.form_id = forms.form_id');
        $this->db->where('booking_forms.form_id', $form_id);
        $this->db->where('booking_forms.booking_id', $booking_id);

        $query = $this->db->get();
        $form = $query->row_array();

        $data['field_ids'] = $form['field_ids'];
        $data['title'] = $form['form_name'];
        $data['completed_by'] = (int)$form['completed_by'];

        $this->load->library('FormBuilder');

        $this->load->view('admin/booking/form', $data);
    }
}
