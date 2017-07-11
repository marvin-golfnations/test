<?php

class TF_Controller extends CI_Controller
{
    protected $data;
    
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Manila');

        $this->load->database();
        $this->load->library('session');

        $this->load->helper(array('url', 'html', 'form', 'date', 'item', 'security', 'event', 'user', 'site', 'forms', 'booking', 'status', 'facility'));
    }
}