<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends TF_Controller {


	public function index()
	{
		if (!$_POST) return;

		$package_id = $this->input->get_post('id');

		$data = array(
			'package_name' => $this->input->get_post('package_name'),
			'duration' => $this->input->get_post('duration'),
			'package_type_id' => $this->input->get_post('package_type_id')
		);

		if ($package_id)
		{
			$this->db->update('packages', $data, array('package_id' => $package_id));
		}
		else {
			$this->db->insert('packages', $data);
			$package_id = $this->db->insert_id();
		}

		$this->db->delete('package_items', array('package_id' => $package_id));

		if ($this->input->get_post('package_items')) {
			$items = array();
			foreach ($_POST['package_items'] as $item => $qty) {
				$items[] = array('package_id' => $package_id, 'item_id' => $item, 'quantity' => $qty);
			}
			$this->db->insert_batch('package_items', $items);
		}

		redirect('backend/packages');

	}
	
	public function edit() {

		$this->load->helper('item');
		$data = array(
			'package_id' => $this->uri->segment(4),
			'package_name' => '',
			'duration' => 1,
			'package_type_id' => 0,
		);

		$query = $this->db->get_where('packages', array('package_id' => $data['package_id']));

		if ($query->num_rows() > 0) {
			$item_data = $query->row_array();
			$data = array_merge($data, $item_data);
		}
		
		$this->db->select('items.item_id, items.title, package_items.quantity, packages.duration, packages.package_type_id');
		$this->db->from('items');
		$this->db->join('package_items', 'items.item_id = package_items.item_id');
		$this->db->join('packages', 'packages.package_id = package_items.package_id');
		$this->db->where('package_items.package_id', $data['package_id']);
		$query = $this->db->get();

		$data['package_items'] = $query->result_array();
		
		$q = $this->db->get('package_types');
		
		
		$package_types = array();
		foreach ($q->result_array() as $row) {
			$package_types[$row['package_type_id']] = $row['package_type_name'];
		}
		
		$data['package_types'] = $package_types;
		
		$this->load->view('admin/package/form', $data);
	}

	public function json() {
		$this->db->select('items.item_id, items.title, package_items.quantity, 1 `included`');
		$this->db->from('items');
		$this->db->join('package_items', 'items.item_id = package_items.item_id');
		$this->db->where('package_items.package_id', $this->uri->segment(4));
		$query = $this->db->get();
		
		$this->output->set_content_type('application/json')->set_output(json_encode($query->result_array()));
	}
}
