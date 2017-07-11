<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends TF_Controller {


	public function index()
	{
		if (!$_POST) return;

		$form_id = $this->input->get_post('id');

		$data = array(
			'form_name' => $this->input->get_post('form_name'),
			'form_html' => $this->input->get_post('form_html')
		);

        $field_ids = array();
        foreach ($_REQUEST['form_fields'] as $field) {
            $field_ids[] = $field['field_id'];
        }

        $data['field_ids'] = implode('|', $field_ids);
        
        if ($form_id)
		{
			$data['author_id'] = get_current_user_id();
			$data['edit_date'] = now();
			$this->db->update('forms', $data, array('form_id' => $form_id));
		}
		else {
			$data['author_id'] = get_current_user_id();
			$data['entry_date'] = now();
			$this->db->insert('forms', $data);
			$form_id = $this->db->insert_id();
		}

        $field_data = array();
        if (isset($_REQUEST['form_fields'])) : 
	        foreach ($_REQUEST['form_fields'] as $field) {
	            $guest_only = 'n';
	            if (isset($field['guest_only'])) $guest_only = 'y';
	            $field_data[] = array(
	                'form_id' => $form_id,
	                'field_id' => $field['field_id'],
	                'guest_only' => $guest_only
	            );
	        }
	
	        $this->db->delete('form_fields', 'form_id='.$form_id);
	        $this->db->insert_batch('form_fields', $field_data);
        endif;

		//Create the form tables.
		$this->load->dbforge();
		$this->dbforge->add_field(array(
			'entry_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'booking_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'author_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'entry_date' => array(
				'type' => 'INT',
				'constraint' => 10),
			'edit_date' => array(
				'type' => 'INT',
				'constraint' => 10),
            'completed_by' => array(
                'type' => 'INT',
                'constraint' => 5),
            'completed_date' => array(
                'type' => 'INT',
                'constraint' => 10)
		));

		$this->dbforge->add_key('entry_id', TRUE);
		$this->dbforge->create_table('form_entries_'.$form_id, TRUE);

		redirect('backend/forms');

	}
	
	public function edit() {

		$data = array(
			'form_id' => $this->uri->segment(4),
			'form_name' => '',
			'form_html'=> '',
			'field_ids' => '',
		);

		$query = $this->db->get_where('forms', array('form_id' => $data['form_id']));

		if ($query->num_rows() > 0) {
			$item_data = $query->row_array();
			$data = array_merge($data, $item_data);
		}
		
		$ids = array();
		if ($data['field_ids']) {
			$ids = explode('|', $data['field_ids']);
			$this->db->select('fields.*, form_fields.guest_only');
			$this->db->from('form_fields');
            $this->db->join('fields', 'fields.field_id = form_fields.field_id');
			$this->db->where_in('form_fields.field_id', $ids);
			$this->db->where('form_id', $data['form_id']);
			$this->db->order_by('FIELD (tf_form_fields.field_id, '.implode(', ', $ids).')');
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
                $data['form_fields'] = $query->result_array();
			}
		}
		
		if ($data['form_html'] === '' && $data['field_ids'] !== '') {
			$this->load->library('FormBuilder');

			ob_start();
			$this->formbuilder->build($data['field_ids'], '');
			$form_html = ob_get_contents();
			ob_end_clean();
			
			$data['form_html'] = $form_html;
		}
		
		$all_fields = array();
		$this->db->select('*');
		$this->db->from('fields');
		if ($ids)
			$this->db->where_not_in('field_id', $ids);
			
		$query = $this->db->get();
		$fields = $query->result_array();
		foreach ($fields as $f) {
			$all_fields[$f['field_id']] = ($f['required'] == 'y' ? '*' : '').$f['field_label'];
		}
		
		$data['all_fields'] = $all_fields;
		$this->load->view('admin/form/edit', $data);
	}

	public function delete() {

		$id = (int)$this->uri->segment(4);
		$confirm = $this->input->get_post('confirm');
		if ($id && $confirm && $confirm === 'y') {

			//@TODO add verification.
			$this->db->delete('forms', array('form_id' => $id));
			$this->db->delete('booking_forms', array('form_id' => $id));
			$this->db->delete('items_related_forms', array('form_id' => $id));

			$this->load->dbforge();
			$this->dbforge->drop_table('form_entries_'.$id);

			if ($return = $this->input->get_post('return'))
				redirect($return);
		}

		redirect('backend/forms');
	}

	function sort() {
		$form_id = (int)$this->uri->segment(4);

		if ($form_id) {
			$field_ids = isset($_POST['field_ids']) ? implode('|', $_POST['field_ids']) : '';
			$this->db->update('forms', array('field_ids' => $field_ids), 'form_id=' . $form_id);
		}
	}
}
