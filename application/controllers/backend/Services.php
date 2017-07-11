<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends TF_Controller {


	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}
		
		$this->db->distinct();
		$this->db->select('items.*');
		$this->db->from('items');
		$this->db->join('item_categories', 'items.item_id = item_categories.item_id', 'left');
		$this->db->join('categories', 'categories.cat_id = item_categories.category_id', 'left');
		if ($this->session->userdata('location_id')) {
			$location = $this->session->userdata('location_id');
			$this->db->where_in('categories.location_id', array(0, $location));
		}

		if ($this->input->get_post('keyword')) {
			$this->db->where("items.title LIKE '%".$this->input->get_post('keyword')."%'");
		}

		if ($this->input->get_post('category')) {
			$this->db->where('categories.cat_id', $this->input->get_post('category'));
			$this->db->or_where('categories.parent_id', $this->input->get_post('category'));
		}
		
		$this->db->order_by('title', 'asc');

		$services = $this->db->get();

		$data = array();
		$data['services'] = $services->result_array();
		$data['categories'] =  get_category_options_2();


		$this->load->view('admin/service/index', $data);
	}
}
