<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Field extends TF_Controller {


	public function index()
	{
		if (!$_POST) {
			redirect('forms');
		}

		$field_id = $this->input->get_post('id');
		$settings = $_REQUEST['settings'];
		$field_type = $this->input->get_post('field_type');
				
		$data = array(
			//'field_name' => $this->input->get_post('field_name'),
			'field_label' => $this->input->get_post('field_label'),
			'field_type' => $this->input->get_post('field_type'),
			'required' => isset($_REQUEST['required']) ? 'y' : 'n',
			'settings' => serialize(array($field_type => isset($settings[$field_type]) ? $settings[$field_type] : false ))
		);
				
		if ($field_id)
		{
			$data['edit_date'] = now();
			$this->db->update('fields', $data, array('field_id' => $field_id));
		}
		else {
			$data['entry_date'] = now();
			$this->db->insert('fields', $data);
			$field_id = $this->db->insert_id();
		}

		redirect('backend/forms');

	}
	
	public function edit() {

		$data = array(
			'field_id' => $this->uri->segment(4),
			'field_name' => '',
			'field_label' => '',
			'field_type' => 'text',
			'required' => 'n',
			'settings' => '',
		);

		$query = $this->db->get_where('fields', array('field_id' => $data['field_id']));

		if ($query->num_rows() > 0) {
			$item_data = $query->row_array();
			$data = array_merge($data, $item_data);
		}
		
		$data['field_types'] = array(
			'text' => 'Text', 
			'dropdown' => 'Dropdown',
			'checkboxes' => 'Checkboxes',
            'radiobuttons' => 'Radio Buttons',
			'datatable' => 'Data Table',
		);
		
		$this->load->view('admin/field/edit', $data);
	}

	public function delete() {

		$id = (int)$this->uri->segment(4);
		$confirm = $this->input->get_post('confirm');
		if ($id && $confirm && $confirm === 'y') {

			//@TODO add verification.
			$this->db->delete('fields', array('field_id' => $id));

			if ($return = $this->input->get_post('return'))
				redirect($return);
		}

		redirect('backend/forms');
	}
}
