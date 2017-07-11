<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends TF_Controller {


	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}
		
        if ($_POST) {
            $this->load->helper('event');
            $event_id = (int)$this->input->get_post('event_id');
            $is_kids = $this->input->get_post('is_kids');
            $item_id = $this->input->get_post('item_id');
            $end_date = $this->input->get_post('end_date');
            $end_time = $this->input->get_post('end_time');
            $start_date = $this->input->get_post('start_date');
            $start_time = $this->input->get_post('start_time');
            $status = $this->input->get_post('status');
            $notes = $this->input->get_post('notes');
            $event_title = $this->input->get_post('event_title') ? $this->input->get_post('event_title') : '';
			
            $data = array(
                'all_day' => 0,
                'status' => $status,
                'event_title' => $event_title,
                'notes' => $notes,
                'item_id' => (int)$item_id,
                'is_kids' => $is_kids
            );

            $data['start_dt'] = date('c', strtotime($start_date . ' ' . $start_time));
            $data['end_dt'] = date('c', strtotime($end_date . ' ' . $end_time));

            if ($facility = $this->input->get_post('facility_id')) {
                $data['facility_id'] = $facility;
            }

            $assignedTo = array();
            if ($assignedTo = $this->input->get_post('assigned_to')) {
                if (!is_array($assignedTo)) $assignedTo = array((int)$assignedTo);
            }

            $event_users = array();

            if ($event_id) {
                $data['edit_date'] = now();
                $this->db->update('booking_events', $data, array('event_id' => $event_id));
                $this->db->delete('booking_event_users', 'event_id=' . $event_id);


                if ($assignedTo) {
                    $event_users = array();
                    foreach ($assignedTo as $user) {
                        $event_users[] = array('event_id' => $event_id, 'staff_id' => $user);
                    }
                    $this->db->insert_batch('booking_event_users', $event_users);
                }


            } else {
                $data['author_id'] = get_current_user_id();
                $data['entry_date'] = now();
                $this->db->insert('booking_events', $data);
                $event_id = $this->db->insert_id();

                if ($event_id && $assignedTo = $this->input->get_post('assigned_to')) {
                    $item_data = $this->item->get($item_id);
                    if ($assignedTo) {
                        $event_users = array();
                        foreach ($assignedTo as $user) {
                            $event_users[] = array('event_id' => $event_id, 'staff_id' => $user);
                        }
                        $this->db->delete('booking_event_users', 'event_id=' . $event_id);
                        $this->db->insert_batch('booking_event_users', $event_users);
                    }

                    $current_user = get_current_user_data();

                    //build message.
                    $message = $current_user['first_name'] . ' ' . $current_user['last_name'] . ' assigned you to <a href="#"> "';
                    if ($item_data) {
                        $message .= $item_data['title'] . ' ';
                    }
                    if ($data['event_title']) {
                        $message .= $data['event_title'] . ' ';
                    }

                    $message .= '"</a> on ' . date('m/d/Y', strtotime($data['start_dt']));

                    $message .= '.';

                    if ($assignedTo) {
                        foreach ($assignedTo as $user) {
                            $this->db->insert('messages', array(
                                'message' => $message,
                                'receiver' => $user,
                                'date_sent' => date('c', now()),
                                'sender' => get_current_user_id(),
                            ));
                        }
                    }
                }
            }
			redirect('backend/events/view/'.($is_kids === 'y' ? 'kids' : ''));
        }
        
		redirect('backend/events/view/');
	}
	
	public function view() {
		
		$is_kids = $this->uri->segment(4) === 'kids';
		
		$is_kids = $is_kids ? 'y' : 'n';
		
		$this->db->distinct();
		$this->db->select('booking_events.*, items.description, items.title as item_name, items.duration, facilities.facility_name, contacts.first_name, contacts.last_name, contacts.nickname');
        $this->db->from('booking_events');
        $this->db->join('items', 'items.item_id = booking_events.item_id');
        $this->db->join('item_categories', 'items.item_id = item_categories.item_id');
        $this->db->join('facilities', 'facilities.facility_id = booking_events.facility_id', 'left');
        $this->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id', 'left');
        $this->db->join('contacts', 'contacts.contact_id = booking_event_users.staff_id', 'left');
        $this->db->where('booking_events.deleted', 'n');
        $this->db->where('booking_events.is_kids', $is_kids);
		$this->db->order_by('booking_events.start_dt', 'asc');
		$results = $this->db->get();

		$data = array();
		$data['is_kids'] = $is_kids;
		$data['activities'] = $results->result_array();

		$this->load->view('admin/event/index', $data);
	}
	
	public function edit() {
		
	
		$is_kids = $this->uri->segment(4) === 'kids';
		$is_kids = $is_kids ? 'y' : 'n';
		$event_id = $this->uri->segment(5);
        $startDate = date('Y-m-d');
        $duration = 60;
		$assigned_to = array();
        $start_date_dt = new DateTime($startDate);
        $end_date_dt = new DateTime($startDate);
        $end_date_dt->add(new DateInterval('PT'.$duration.'M'));
        $data = array();

        $event_data = array(
            'guest_id' => 0,
            'facility_id' => 0,
            'status' => 'tentative',
            'event_title' => '',
            'notes' => '',
            'item_id' => 0,
            'is_kids' => $is_kids,
            'assigned_to' => $assigned_to,
            'author_id' => $this->session->userdata('user_id'),
            'start_dt' => $start_date_dt->format('Y-m-d H:i:s'),
            'end_dt' => $end_date_dt->format('Y-m-d H:i:s'),
        );


        if($event_id) {

            $this->db->select('booking_events.*');
            $this->db->from('booking_events');
            $this->db->join('items', 'booking_events.item_id=items.item_id', 'left');
            $this->db->where('event_id = ', $event_id);
            $event_data = $this->db->get()->row_array();
            
            $query = $this->db->get_where('booking_event_users', 'event_id='.$event_id);
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row) {
	                $assigned_to[] = (int)$row['staff_id'];
	            }
	        }
        }

        $data = array(
            'event_id' => (int)$event_id,
            'author_id' => (int)$event_data['author_id'],
            'item_id' => (int)$event_data['item_id'],
            'facility_id' => (int)$event_data['facility_id'],
            'status' => $event_data['status'],
            'event_title' => $event_data['event_title'],
            'notes' => $event_data['notes'],
            'is_kids' => $event_data['is_kids'],
            'start_date' => date('m/d/Y', strtotime($event_data['start_dt'])),
            'start_time' => date('H:i', strtotime($event_data['start_dt'])),
            'end_date' => date('m/d/Y', strtotime($event_data['end_dt'])),
            'end_time' => date('H:i', strtotime($event_data['end_dt'])),
        );
        
        $facilities = array();

        $this->db->select('facility_id, facility_name');
        $this->db->from('facilities');
        $this->db->where('facilities.status', 1);
        if ($this->session->userdata('location'))
        {
            $this->db->where_in('facilities.location_id', $this->session->userdata('location'));
        }

        foreach ($this->db->get()->result_array() as $row) {
            $facilities[$row['facility_id']] = $row['facility_name'];
        }

        $params = array();
        $params['start'] = date('Y-m-d H:i:s', strtotime($event_data['start_dt']));
        $params['end'] = date('Y-m-d H:i:s', strtotime($event_data['end_dt']));
        $params['event'] = (int)$event_id;
        $params['status'] = $event_data['status'];
        $params['item_id'] = (int)$event_data['item_id'];
        $params['exclude_peoples'] = array();
        $params['exclude_facilities'] = array();
        $params['exclude_status'] = array();
        $params['people'] = $assigned_to;

        $this->load->library('availability', $params);
        $this->availability->validate();
        
        $data['assigned_to'] = $assigned_to;
        
        $data['yes_no'] = array('y' => 'Yes', 'n' => 'No');
		
		$select_facility = array();

        $facilities = keyval($this->availability->get_available_facilities(), 'facility_id', 'facility_name', false, $select_facility);
        $data['facilities'] = $facilities;
	
		$select_provider = array();
        $providers = keyval($this->availability->get_available_peoples(), 'contact_id', array('first_name', 'last_name'), 'position', $select_provider);
        $data['providers'] = $providers;

        $data['statuses'] = get_statuses(2);
        
		$categories = array(9);
		
        if ($data['is_kids'] === 'y') {
	    	$categories = array(10);    
        }

        $data['times'] = createTimeRangeArray(1800*12, 3600*23, 60*10);
        
        $data['categories'] = $categories;
        
        $data['return'] = 'backend/events/view/'.($data['is_kids'] === 'y' ? 'kids' : 'adult');

		$this->load->view('admin/event/form', $data);
	}
	
	public function delete()
    {
        $event_id = $this->uri->segment(4);

        $this->db->update('booking_events', array(
            'deleted' => 'y',
            'deleted_by' => get_current_user_id(),
            'deleted_date' => now()), 'event_id=' . (int)$event_id);

        $return = $this->input->get_post('return');

        $this->session->set_flashdata('message', 'Activity successfully deleted.');

        redirect($return);
    }
}
