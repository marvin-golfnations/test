<?php

class Contacts_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function get_contact($id) {
        $query = $this->db->get_where('contacts', array('contact_id' => $id));

        return $query->row_array();
    }
}