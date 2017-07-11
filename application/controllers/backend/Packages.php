<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends TF_Controller {


	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}

		$data = array();
		$data['packages'] = $this->db->get('packages')->result_array();
		
		$this->load->view('admin/package/index', $data);
	}
}
