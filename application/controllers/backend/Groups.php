<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends TF_Controller {


	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}

		$data = array();
		$data['groups'] = $this->db->get('groups')->result_array();


		$this->load->view('admin/group/index', $data);
	}
}
