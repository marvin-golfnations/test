<?php

class Items_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function get($id) {
        $query = $this->db->get_where('items', array('item_id' => $id));

        if ($query->num_rows() > 0)
            return $query->row_array();

        return null;
    }

    public function get_users($id) {

    }

    public function get_forms($id) {

    }

    public function get_facilities($id) {
        $this->db->select('facilities.*');
        $this->db->from('items_related_facilities');
        $this->db->join('facilities', 'facilities.facility_id=items_related_facilities.facility_id');
        $this->db->where('item_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }
}