<?php

function get_user($user_id) {
    $TF =& get_instance();

    $query = $TF->db->get_where('contacts', array('contact_id' => $user_id));

    return $query->row_array();
}

function get_current_user_data() {
    return get_user(get_current_user_id());
}
//commit test
function get_current_user_id() {
    $TF =& get_instance();
    return (int)$TF->session->userdata('user_id');
}

function get_current_user_group() {
    $TF =& get_instance();
    
    $TF->db->select('*');
	$TF->db->from('contacts');
	$TF->db->join('users', 'contacts.contact_id = users.contact_id');
	$TF->db->join('groups', 'users.group_id = groups.group_id');
	$TF->db->where('contacts.contact_id', get_current_user_id());
	$query = $TF->db->get();
	
	if ($query->num_rows() === 0) return null;

	return $query->row_array();
}

function get_current_user_photo() {
    $TF =& get_instance();
    if ($TF->session->userdata('avatar')) {
        return $TF->session->userdata('avatar');
    }
    
    return '/images/avatars/default_avatar_male.jpg';
}

function current_user_can($permission, $user_id = 0) {
    $TF =& get_instance();
    
    if ($user_id === 0) {
	    $user_id = $TF->session->userdata('user_id');
	    
	    if (is_admin()) return true;
	}
    
    
	$TF->db->select('*');
	$TF->db->from('contacts');
	$TF->db->join('users', 'contacts.contact_id = users.contact_id');
	$TF->db->join('groups', 'users.group_id = groups.group_id');
	$TF->db->where('contacts.contact_id', $user_id);
	$query = $TF->db->get();
	
	if ($query->num_rows() === 0) return false;

	$row = $query->row_array();
	
	if (!isset($row[$permission])) return false;
	
	if ($row[$permission] === 'y') return true;

    return false;
}

function is_admin() {

    $TF =& get_instance();
    if ($TF->session->userdata('group_id') === 1) return true;

    return false;
}

function is_guest() {
    $TF =& get_instance();
    if ($TF->session->userdata('group_id') === 5) return true;

    return false;
}

function is_logged_in() {
    if (get_current_user_id() === 0) return false;
    return true;
}

function tf_user_groups() {
    $TF =& get_instance();
    $results = $TF->db->get('groups')->result_array();
    $groups = array();
    foreach ($results as $row) {
        $groups[$row['group_id']] = $row['group_name'];
    }

    return $groups;
}

function get_all_locations() {
    $TF =& get_instance();

    $TF->db->reset_query();
    $TF->db->select('*');
    $TF->db->from('locations');
    $query = $TF->db->get();

    $result = $query->result_array();

    $query->free_result();

    return $result;
}

function get_locations() {

    $TF =& get_instance();
    $TF->db->select('*');
    $TF->db->from('locations');

    if ($TF->session->userdata('location')) {
        $TF->db->where_in('location_id', $TF->session->userdata('location'));
    }

    $locations = array();

    if ($TF->session->userdata('group_id') === 1) {
        $locations[0] = 'All';
    }

    $q = $TF->db->get();
    if ($q->num_rows() > 0) {
        $results = $q->result_array();
        foreach($results as $row) {
            $locations[(int)$row['location_id']] = $row['location'];
        }
    }

    return $locations;
}

function tf_get_current_booking($user_id) {
	
	$TF =& get_instance();
	$TF->db->select('*');
	$TF->db->from('bookings');
	$TF->db->where('bookings.guest_id', $user_id);
	$TF->db->where_in('bookings.status', array('confirmed')); //, 2);
	
	$query = $TF->db->get();
    
	return $query->row_array();
}

function get_provider_list($exclude = array(), $include = array(), $positions = array(), $locations = array()) {
	
	$TF =& get_instance();
	$TF->db->select('contacts.*, users.*');
	$TF->db->join('users', 'users.contact_id = contacts.contact_id');
	$TF->db->join('groups', 'groups.group_id = users.group_id');
	if ($exclude) {
		if (!is_array($exclude)) $exclude = array($exclude);
		$TF->db->where_not_in('contacts.contact_id', $exclude);
	}
	
	if ($include) {
		if (!is_array($include)) $include = array($include);
		$TF->db->where_in('contacts.contact_id', $include);
	}
	
	if ($positions) {
		if (!is_array($positions)) $positions = array($positions);
		$TF->db->where_in('contacts.position', $positions);
	}
	
	if ($locations)
	{
		if (!is_array($locations)) $locations = array($locations);
		if ($locations)
			$TF->db->where_in('users.location_id', $locations);
	}
	
	$TF->db->where('groups.include_in_provider_list = "y"');
	$TF->db->order_by('order', 'asc');
	$query = $TF->db->get('contacts');
	
	
	return $query->result_array();
	
}

function get_service_providers($user_ids = false) {
	
	$TF =& get_instance();
	$TF->db->select('contacts.*, users.*');
	$TF->db->from('contacts');
	$TF->db->join('users', 'users.contact_id = contacts.contact_id');
	if ($user_ids) {
		if (!is_array($user_ids)) $user_ids = array($user_ids);
		if (count($user_ids) > 0) $TF->db->where_in('users.contact_id', $user_ids);
	}
	
	$query = $TF->db->get();
	if ($query->num_rows() === 0)
		return false;
	
	return $query->result_array();
	
    $users = get_users(false, array(3));
    $providers = array();
    foreach ($users as $user) {
        $providers[$user['contact_id']] = $user['first_name'] . ' ' . $user['last_name'];
    }
    return $providers;
}

function get_admin_users() {
    $users = get_users(false, array(1, 2));

    $admin_users = array();
    foreach ($users as $user) {
        $admin_users[$user['contact_id']] = $user['first_name'] . ' ' . $user['last_name'];
    }
    return $admin_users;
}

function get_users($user_ids = false, $group_ids = false) {
    $TF =& get_instance();
    $TF->db->select('contacts.*, users.*');
    $TF->db->from('contacts');
    $TF->db->join('users', 'users.contact_id = contacts.contact_id');
    if ($user_ids) {
	    if (!is_array($user_ids)) $user_ids = array($user_ids);
	    if (count($user_ids) > 0) $TF->db->where_in('users.contact_id', $user_ids);
    }

    if ($TF->session->userdata('location')) {

        $locations = array();
        $location = $TF->session->userdata('location');
        for($i=0; $i<count($location); $i++) {
	        
	        
	        if ($location[$i]) {
	            $can_view = $TF->session->userdata('can_view_schedules_'.$location[$i]);
	            if ($can_view === 'y') $locations[] = $location[$i];
	        }
        }
		if ($locations) $TF->db->where_in('users.location_id', $locations);
    }

    $query = $TF->db->get();
    if ($query->num_rows() === 0)
        return false;

    return $query->result_array();
}

function get_user_group($group_id)
{
    $TF =& get_instance();
    $query = $TF->db->get_where('groups', 'group_id = '.(int)$group_id);

    return $query->row_array();
}

function get_audit_users($exclude = array(), $include = array()) {

    $TF =& get_instance();
    $TF->db->select('contacts.*, users.*');
    $TF->db->join('users', 'users.contact_id = contacts.contact_id');
    $TF->db->join('groups', 'groups.group_id = users.group_id');
    if ($exclude) {
        if (!is_array($exclude)) $exclude = array($exclude);
        $TF->db->where('contacts.contact_id NOT IN ('.implode(', ', $exclude).')');
    }

    if ($include) {
        if (!is_array($include)) $include = array($include);
        $TF->db->where('contacts.contact_id IN ('.implode(', ', $include).')');
    }

    //if ($TF->session->userdata('location')) {
    //    $TF->db->where_in('users.location_id', $TF->session->userdata('location'));
    //}

    $TF->db->where('groups.include_in_audit_list = "y"');
    $TF->db->order_by('last_name', 'asc');
    $query = $TF->db->get('contacts');
    
    return $query->result_array();

}