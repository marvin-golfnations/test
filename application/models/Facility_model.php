<?php

class Facility_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($id) {
        return null;
    }

    function all() {

        if ($this->session->userdata('location')) {

            $locations = array(0);
            $location = $this->session->userdata('location');
            for($i=0; $i<count($location); $i++) {
                $locations[] = (int)$location[$i];
            }

            if ($locations)
                $this->db->where_in('location_id', $locations);
        }
        
        $this->db->order_by('facility_name');

        $query = $this->db->get('facilities');
		
        if ($query->num_rows() > 0)
            return $query->result_array();

        return array();
    }
}