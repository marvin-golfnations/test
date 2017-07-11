<?php

function booking_form_entries($booking_id, $form_id) {

    if ($booking_id === 0) return false;

    $TF =& get_instance();
    $TF->db->where('booking_id', $booking_id);
    return $TF->db->get('form_entries_'.$form_id)->row_array();
}

function booking_forms($booking_id, $submitted = '') {

    if (!$booking_id) return false;

    $TF =& get_instance();
    $TF->db->from('booking_forms');
    $TF->db->join('forms', 'forms.form_id = booking_forms.form_id');
    $TF->db->where('booking_id', $booking_id);

    if ($submitted) {
        $TF->db->where('submitted = \''.$submitted.'\'');
    }

    return $TF->db->get()->result_array();
}

function get_bookings($contact_id, $status = -1) {

    $TF =& get_instance();
    $TF->db->select('bookings.*');
    $TF->db->from('bookings');
    $TF->db->where('bookings.guest_id', $contact_id);

    if ($status !== -1)
        $TF->db->where('bookings.status = ', $status);

    $query = $TF->db->get();

    if ($query->num_rows() > 0)
        return $query->result_array();

    return array();
}

function available_booking_items($booking_id = 0, $categories = false)
{
    $TF =& get_instance();

    //if (!$booking_id) return '';
    $output = array(); //'' => '-Select-');
    $exclude_items = array();
    if ($booking_id)
	{
	    $TF->db->select('items.item_id, items.title, bookings.title AS program_name, items.duration');
	    $TF->db->from('items, booking_items');
	    $TF->db->join('bookings', 'bookings.booking_id = booking_items.booking_id');
	    $TF->db->where('items.item_id = booking_items.item_id');
	    if ($booking_id)
	        $TF->db->where('bookings.booking_id = '.$booking_id);
		$TF->db->order_by('items.title', 'ASC');
	    $query = $TF->db->get();

	    if ($query->num_rows() > 0) {
	
	        foreach ($query->result_array() as $row) {
	            $exclude_items[] = $row['item_id'];
	            $output[$row['program_name']][$row['item_id']] = $row['title'].($row['duration'] ? sprintf(' (%d mins)', (int)$row['duration']) : '');
	        }
	    }
        $query->free_result();
	}

    $locations = array();
    if ($TF->session->userdata('location'))
    {
        $all_location = get_all_locations();
        foreach ($all_location as $_row) {
            if (current_user_can('can_edit_schedules_'.$_row['location_id'])) {
                $locations[] = $_row['location_id'];
            }
        }
    }

    $TF->db->select('items.item_id, item_categories.category_id, categories.cat_name, items.title, items.duration');
    $TF->db->from('items');
    $TF->db->join('item_categories', 'items.item_id = item_categories.item_id');
    $TF->db->join('categories', 'categories.cat_id = item_categories.category_id');
    if ($exclude_items)
        $TF->db->where('items.item_id NOT IN ('.implode(', ', $exclude_items).')');
        
    if ($categories) {
	    $TF->db->where_in('categories.cat_id', $categories);
    }

    if ($locations)
        $TF->db->where_in('categories.location_id', $locations);
    
    $TF->db->order_by('items.title', 'ASC');

    $query = $TF->db->get();
    
    foreach ($query->result_array() as $row) {
        $output[$row['cat_name']][$row['item_id']] = $row['title'].($row['duration'] ? sprintf(' (%d mins)', (int)$row['duration']) : '');
    }
    
    foreach ($output as $parent => $arr) {
	    
	    if (is_array($arr))
	    { 
		    asort($arr);
			$output[$parent] = $arr;
		}
    }

    return $output;
}

function booking_items($booking_id, $booking_status = -1, $available_only = false)
{
    $TF = get_instance();

	$TF->db->distinct();
    $TF->db->select('items.item_id, items.title, 
    	booking_items.quantity, booking_items.included, 
    	items.duration, items.uom, booking_items.booking_item_id, 
    	booking_items.upsell, booking_items.foc, 
    	(SELECT COUNT(*) FROM tf_booking_events events WHERE events.booking_item_id=tf_booking_items.booking_item_id AND events.deleted = 0) AS inventory');
    $TF->db->from('items');
    $TF->db->join('booking_items', 'items.item_id = booking_items.item_id', 'left');
    $TF->db->join('bookings', 'booking_items.booking_id = bookings.booking_id');

    if ($TF->session->userdata('location'))
    {
        $TF->db->join('item_categories', 'items.item_id = item_categories.item_id');
        $TF->db->join('categories', 'categories.cat_id = item_categories.category_id');
        $TF->db->where_in('categories.location_id', $TF->session->userdata('location'));
    }

    if ($booking_status !== -1)
        $TF->db->where('bookings.status', $booking_status);

    if ($available_only) {
        //$TF->db->where('booking_items.inventory > 0');
    }

    $TF->db->where('booking_items.booking_id', $booking_id);
    //$TF->db->where('booking_items.quantity > ', 0);
    $query = $TF->db->get();
    $result = $query->result_array();

    return $result;
}
