<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends TF_Controller {



	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}
		$this->load->view('welcome_message');
	}

	public function change() {

		if ($this->session->userdata('group_id') === 1) {

			$userdata = $this->session->userdata;
			$userdata['location_id'] = (int)$this->uri->segment(3);

			$this->session->set_userdata($userdata);
		}

		redirect($_SERVER['HTTP_REFERER']);

	}
}
