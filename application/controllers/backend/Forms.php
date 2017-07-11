<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends TF_Controller {
	
	public function index() {
		
		$data['forms'] = $this->db->get('forms')->result_array();
		$data['fields'] = $this->db->get('fields')->result_array();
		
		$this->load->view('admin/form/index', $data);
	}
	
}