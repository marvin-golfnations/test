<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends TF_Controller {

	public function index()
	{
		$this->load->library('facebook');
		$this->load->view('login');
		
		$this->session->sess_destroy();
		
		redirect($this->input->get_post('return'));
	}
}
