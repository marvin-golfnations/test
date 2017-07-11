<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Providers extends TF_Controller {

    public function index() {
        $data = array();
        $data['group_name'] = 'Service Providers';
        $data['contacts'] = get_provider_list(false, false, false, $this->session->userdata('location_id'));
        $this->load->view('admin/providers/index', $data);
    }
    
    public function order() {
        $data['contacts'] = get_provider_list(false, false, false, $this->session->userdata('location_id'));
        $this->load->view('admin/providers/order', $data);
    }
    
    public function update() {
	    
	    foreach ($_POST['order'] as $idx => $contact_id) {
			$this->db->update('users', array('order' => $idx), 'contact_id='.$contact_id);
	    }
	    
	    redirect('backend/providers');
	    
    }
}
