<?php

function get_facilities() {
    $TF =& get_instance();
    $TF->db->select('*');

    if ($TF->session->userdata('location')) {

        $locations = array(0);
        $location = $TF->session->userdata('location');
        for($i=0; $i<count($location); $i++) {
            $locations[] = (int)$location[$i];
        }

        if ($locations)
            $TF->db->where_in('location_id', $locations);
    }

    $query = $TF->db->get('facilities');
    return $query->result_array();
}