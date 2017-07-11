<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends TF_Controller {


	public function index()
	{
		if (!$_POST) return;

		$item_id = $this->input->get_post('id');

		$duration = (intval($this->input->get_post('duration_hours')) * 60) + intval($this->input->get_post('duration_minutes'));

		$data = array(
			'title' => $this->input->get_post('title'),
			'duration' => $duration,
			'abbr' => $this->input->get_post('abbr'),
			'amount' => (float)$this->input->get_post('amount'),
			'max_provider' => (int)$this->input->get_post('max_provider'),
			'description' => $this->input->get_post('description'),
		);
		
		$config = get_upload_config(1);
		
		$this->load->library('upload', $config);
		
		if ($this->upload->do_upload('item_image')) {
			$file = $this->upload->data();
			
			$this->db->insert('files', array(
				'title' => $file['file_name'],
				'file_name' => $file['file_name'],
				'file_size' => $file['file_size'],
				'upload_id' => 1,
				'upload_date' => now(),
			));
			
			$data['item_image'] = (int)$this->db->insert_id();
		}
		else {
			$this->session->set_flashdata('error_message', $this->upload->display_errors('', ''));
		}

		if ($item_id)
		{
			$this->db->update('items', $data, array('item_id' => $item_id));
		}
		else {
			$this->db->insert('items', $data);
			$item_id = $this->db->insert_id();
		}

		if ($this->input->get_post('day_settings') || $this->input->get_post('day_settings')) {
		    $day_settings = array();
		    foreach ($this->input->get_post('day_settings') as $value) {
		        $day_settings[] = $value;
            }
            $time_settings = array();
            foreach ($this->input->get_post('time_settings') as $value) {
                $time_settings[] = $value;
            }
            $this->db->delete('item_day_time_settings', array('item_id' => $item_id));

            for($i=0; $i<count($day_settings); $i++) {
                $this->db->insert('item_day_time_settings', array(
                    'day_settings' => $day_settings[$i],
                    'time_settings' => $time_settings[$i],
                    'item_id' => $item_id
                ));
            }
        }

		if ($this->input->get_post('related_user_ids'))
		{
			$this->db->delete('items_related_users', array('item_id' => $item_id));
			$insert = array();
			foreach ($this->input->get_post('related_user_ids') as $id)
			{
				$insert[] = array('contact_id' => $id, 'item_id' => $item_id);
			}
			$this->db->insert_batch('items_related_users', $insert);
		}

		if ($this->input->get_post('related_form_ids'))
		{
			$this->db->delete('items_related_forms', array('item_id' => $item_id));
			$insert = array();
			foreach ($this->input->get_post('related_form_ids') as $id)
			{
				$insert[] = array('form_id' => $id, 'item_id' => $item_id);
			}
			$this->db->insert_batch('items_related_forms', $insert);
		}

        if ($this->input->get_post('related_facility_ids'))
        {
            $this->db->delete('items_related_facilities', array('item_id' => $item_id));
            $insert = array();
            foreach ($this->input->get_post('related_facility_ids') as $id)
            {
                $insert[] = array('facility_id' => $id, 'item_id' => $item_id);
            }
            $this->db->insert_batch('items_related_facilities', $insert);
        }

		if ($this->input->get_post('item_categories'))
		{

			$this->db->delete('item_categories', array('item_id' => $item_id));
			foreach ($this->input->get_post('item_categories') as $cat)
			{
				$this->db->insert('item_categories', array('category_id' => $cat, 'item_id' => $item_id));
			}
		}
		
		

		redirect($this->input->get_post('return'));

	}

	public function related_forms() {
		$this->db->select('forms.form_name, forms.form_id');
		$this->db->from('items_related_forms');
		$this->db->join('forms', 'forms.form_id = items_related_forms.form_id');
		$this->db->where_in('items_related_forms.item_id', explode('|', $_REQUEST['ids']));

		$query = $this->db->get();

		echo json_encode($query->result_array());
	}

	public function delete_user() {
		$contact_id = (int)$this->uri->segment(4);
		$item_id = (int)$this->uri->segment(4);

		$confirm = $this->input->get_post('confirm');
		if ($confirm === 'y') {
			$this->db->delete('items_related_users', 'contact_id='.$contact_id.' AND item_id='.$item_id);
			echo $item_id;
		}
	}

	public function add_user() {
		$contact_id = (int)$this->uri->segment(4);
		$item_id = (int)$this->uri->segment(4);
		$confirm = $this->input->get_post('confirm');
		if ($confirm === 'y') {
			$this->db->insert('items_related_users', array('contact_id' => $contact_id, 'item_id' => $item_id));
			echo $item_id;
		}
	}
	
	public function edit() {

		$data = array(
			'item_id' => $this->uri->segment(4),
			'duration_hr' => '',
			'duration_min' => '',
			'amount' => '',
			'title' => '',
			'abbr' => '',
			'max_provider' => 1,
			'description' => '',
			'item_image' => 0,
            'default_time' => '',
		);

        $items = $this->item->get($data['item_id']);

		if ($items) {
			$data = array_merge($data, $items);

			$data['duration_hr'] = floor(intval($data['duration']) / 60);

			$data['duration_min'] = intval($data['duration']) % 60;
		}
		
		$data['categories'] = get_category_options_2();

		$query = $this->db->select('category_id')->where(array('item_id' => $data['item_id']))->get('item_categories');

		$item_categories = array();
		foreach ($query->result_array() as $row)
		{
			$item_categories[] = $row['category_id'];
		}

		$data['item_categories'] = $item_categories;
		
		$providers = get_provider_list(false, false, false, $this->session->userdata('location_id'));
		$providers_array = array();
		$data['providers'] = keyval($providers, 'contact_id', array('first_name', 'last_name'), 'position', $providers_array);

		$related_user_ids = array();
		$query = $this->db->select('contact_id')->where('item_id', $data['item_id'])->get('items_related_users');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$related_user_ids[] = $row['contact_id'];
			}
		}
		
		$data['related_user_ids'] = $related_user_ids;
		
		$related_facility_ids = array();
        $related_facilities = $this->item->get_facilities($data['item_id']);
		if ($related_facilities) {
			foreach ($related_facilities as $row) {
				$related_facility_ids[] = $row['facility_id'];
			}
		}

		$facilities = $this->facility->all();

        $facilities_array = array();
        if ($facilities) {
            foreach ($facilities as $row) {
                $facilities_array[$row['facility_id']] = $row['facility_name'];
            }
        }

		$data['facilities'] = $facilities_array;
		$data['related_facility_ids'] = $related_facility_ids;

		$query = $this->db->get('forms');
		$forms = array();

		foreach ($query->result_array() as $row) {
			$forms[$row['form_id']] = $row['form_name'];
		}

		$data['forms'] = $forms;

		$related_form_ids = array();
		$query = $this->db->select('form_id')->where('item_id', $data['item_id'])->get('items_related_forms');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$related_form_ids[] = $row['form_id'];
			}
		}

		$data['related_form_ids'] = $related_form_ids;

		$day_time_settings = array(array(
		    'day_settings' => '',
            'time_settings' => ''
        ));
		$query = $this->db->get_where('item_day_time_settings', array('item_id' => $data['item_id']));
		if ($query->num_rows() > 0) {
		    $day_time_settings = $query->result_array();
        }

        $data['day_time_settings'] = $day_time_settings;

		$this->load->view('admin/service/form', $data);
	}

	public function delete() {

		$id = (int)$this->uri->segment(4);
		$confirm = $this->input->get_post('confirm');
		if ($id && $confirm && $confirm === 'y') {
			//check if the item is in use.
			$this->db->select('items.title');
			$this->db->from('booking_items');
			$this->db->join('items', 'booking_items.item_id = items.item_id');
			$this->db->where('items.item_id', $id);
			$q = $this->db->get();
			if ($q->num_rows() > 0) {
				$r = $q->row_array();
				show_error($r['title'] . ' is currently in used.');
				return;
			}

			$this->db->delete('items', array('item_id' => $id));

			if ($return = $this->input->get_post('return'))
				redirect($return);
		}

		redirect('backend/services');
	}

	public function json() {
		$query = $this->db->get_where('items', array('item_id' => $this->uri->segment(4)));

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($query->result_array()));
	}
}
