<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lock extends TF_Controller {

	public function index()
	{
		$this->session->sess_destroy();
		$this->load->view('lock');
	}
}
