<?php

class Bookings_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function get_booking($id) {
        $query = $this->db->get_where('bookings', array('booking_id' => $id));

        return $query->row_array();
    }
}