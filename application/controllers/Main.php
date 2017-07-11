<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends TF_Controller {

	function index() {
		
		
		$this->load->view('index');
	}
	
}