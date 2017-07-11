<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends TF_Controller {


    public function index() {
        $data = array();

        $this->db->select('contacts.*');
        $this->db->join('users', 'contacts.contact_id = users.contact_id');
        $this->db->where('users.group_id IN (1, 2)');
        if ($keyword = $this->input->get_post('keyword')) {
            $this->db->where("(first_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' OR email LIKE '%$keyword%')");
        }

        $this->db->where('contacts.deleted = 0');
        $query = $this->db->get('contacts');

        $contacts = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $contacts[] = $row;
            }
        }

        $data['group_name'] = 'Admin Users';
        $data['contacts'] = $contacts;
        $this->load->view('admin/users/index', $data);
    }



}
