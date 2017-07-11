<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends TF_Controller
{
    function edit() {
        $data['contact_id'] = (int)$this->uri->segment(3);

        $this->db->select('email');
        $this->db->where('contact_id = '.$data['contact_id']);
        $q = $this->db->get('contacts');
        $r = $q->row_array();
        $data['email'] = $r['email'];

        $this->load->view('message/form', $data);
    }

    function send() {

        $this->load->library('email');
        $this->email->from('info@thefarm.com.ph', site_title());
        $this->email->to($this->input->get_post('to'));
        $this->email->subject($this->input->get_post('subject'));
        $this->email->message($this->input->get_post('message'));
        $this->email->send();
    }
}