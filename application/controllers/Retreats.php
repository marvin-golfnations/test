<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retreats extends TF_Controller {
	
	function index() {
		
		$data = array();
		
		$this->db->select('*');
		$query = $this->db->get('package_types');
		$data['package_types'] = $query->result_array();
		
		$this->load->view('retreats', $data);
	}
	
	function book() {
		
		$data = array(
			'title' => '',
			'package_id' => (int)$this->input->get_post('package_id'),
			'status' => 'tentative',
			'guest_id' => $this->session->userdata('user_id'),
			'fax' => 1,
		);
		
		if ($start_date = $this->input->get_post('start_date')) {
			$data['start_date'] = strtotime($start_date);
		}
		
		if ($end_date = $this->input->get_post('end_date')) {
			$data['end_date'] = strtotime($end_date);
		}
		
		$data['entry_date'] = now();
		$data['author_id'] = get_current_user_id();
		
		$this->db->insert('bookings', $data);
		
		redirect($this->input->get_post('return'));
	}
	
	function packages() {
		
		$data = array();
		$this->load->library('facebook');
		$this->db->select('*');
		$query = $this->db->get_where('package_types', 'package_type_id='.$this->uri->segment(3));
		$data['package_type'] = $query->row_array();
		
		$this->db->select('packages.*, items.title, items.item_id, package_items.quantity, categories.cat_id as category_id, categories.cat_name as category_name');
		$this->db->join('package_items','packages.package_id = package_items.package_id');
		$this->db->join('items', 'package_items.item_id=items.item_id');
		$this->db->join('item_categories', 'items.item_id=item_categories.item_id');
		$this->db->join('categories', 'item_categories.category_id=categories.cat_id');
		$this->db->where('package_type_id='.$this->uri->segment(3));
		$this->db->where_in('categories.cat_id', array(1, 2));
		$this->db->order_by('duration');
		$query = $this->db->get('packages');
		$packages = array();
		$items = array();
		$durations = array();
		
		foreach($query->result_array() as $package) {
			$items[$package['category_name']][$package['item_id']] = $package['title'];
			$durations[$package['package_id']] = $package['duration'];
			$packages[$package['package_id']][(int)$package['item_id']] = $package['quantity'];
		}
		
		$data['packages'] = $packages;
		$data['durations'] = $durations;
		$data['items'] = $items;
		
		$this->db->select('*');
		$query = $this->db->get_where('package_types', 'package_types.package_type_id != '.$this->uri->segment(3));
		$data['package_types'] = $query->result_array();
		
		$this->load->view('retreats/packages', $data);
		
	}
		
}