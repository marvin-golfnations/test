<?php
function get_statuses($group_id, $include_in_sales = -1, $include_in_duplicate_checking = -1) {
    $TF =& get_instance();

    $TF->db->select('*');
    $TF->db->from('statuses');
    $TF->db->where('group_id', (int)$group_id);

    if ($include_in_sales !== -1)
        $TF->db->where('include_in_sales', $include_in_sales ? 'y' : 'n');

    if ($include_in_duplicate_checking !== -1) {
        $TF->db->where('include_in_duplicate_checking', $include_in_duplicate_checking ? 'y' : 'n');
    }

    $query = $TF->db->get();

    $statuses = array();
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $statuses[strtolower($row['status_name'])] = $row['status_name'];
        }
    }
	$query->free_result();
    return $statuses;
}

function get_event_statuses($include_in_sales = -1, $include_in_duplicate_checking = -1) {
    $TF =& get_instance();

    $TF->db->select('*');
    $TF->db->from('event_status');

    if ($include_in_sales !== -1)
        $TF->db->where('include_in_sales', $include_in_sales ? 'y' : 'n');

    if ($include_in_duplicate_checking !== -1) {
        $TF->db->where('include_in_duplicate_checking', $include_in_duplicate_checking ? 'y' : 'n');
    }

    $query = $TF->db->get();

    $statuses = array();
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $statuses[$row['status_cd']] = $row['status_value'];
        }
    }
    $query->free_result();
    return $statuses;
}

function get_booking_statuses() {
    $TF =& get_instance();

    $TF->db->select('*');
    $TF->db->from('booking_status');

    $query = $TF->db->get();

    $statuses = array();
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $statuses[$row['status_cd']] = $row['status_value'];
        }
    }
    $query->free_result();
    return $statuses;
}

function get_statuses_style($group_id) {
    $TF =& get_instance();

    $TF->db->select('*');
    $TF->db->from('statuses');
    $TF->db->where('group_id', (int)$group_id);

    $query = $TF->db->get();

    $statuses = array();
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $statuses[strtolower($row['status_name'])] = $row['status_style'];
        }
    }
	$query->free_result();
    return $statuses;
}

function get_event_status_styles() {
    $TF =& get_instance();

    $TF->db->select('*');
    $TF->db->from('event_status');

    $query = $TF->db->get();

    $statuses = array();
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $statuses[$row['status_cd']] = $row['status_style'];
        }
    }
    $query->free_result();
    return $statuses;
}