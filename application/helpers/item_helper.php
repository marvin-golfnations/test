<?php
	
function get_services($id = false, $exclude_id = false)
{
	$TF =& get_instance();

    $TF->db->select('items.item_id, item_categories.category_id, categories.cat_name, items.title, items.duration');
    $TF->db->from('items');
    $TF->db->join('item_categories', 'items.item_id = item_categories.item_id');
    $TF->db->join('categories', 'categories.cat_id = item_categories.category_id');
    $TF->db->order_by('items.title');

    if ($TF->session->userdata('location')) {
	    $location = $TF->session->userdata('location');
	    $location[] = 0;
        $TF->db->where_in('categories.location_id', $location);
    }
    
    if ($id) {
	    if (!is_array($id)) {
		   $id = array($id);
	    }
	    
	    $TF->db->where('items.item_id IN ('.implode(',', $id).')');
    }
    
    if ($exclude_id) {
	    if (!is_array($exclude_id)) {
		   $exclude_id = array($exclude_id);
	    }
	    
	    $TF->db->where('items.item_id NOT IN ('.implode(',', $exclude_id).')');
    }

    $query = $TF->db->get();
    
    return $query->result_array();
}	

function items_dropdown($name, $selected='', $attr = '')
{
    //$options = array('' => '-Select-');
    foreach (get_services() as $row)
    {
        $duration =  (int)$row['duration'];
        $options[$row['cat_name']][$row['item_id']] = $row['title'] . ($duration > 0 ? ' ('.$duration.' mins)' : '');
    }

    return form_dropdown($name, $options, $selected, $attr);
}


function get_categories($parent_id=-1, $include_parent = false) {

    $TF = get_instance();
    $TF->db->select('categories.*');
    $TF->db->from('categories');
    
    
    if ($TF->session->userdata('group_id') !== 5) {
	    if ($TF->session->userdata('location')) {
		    $locations = $TF->session->userdata('location');
		    $locations[] = 0;
	        $TF->db->where_in('categories.location_id', $locations); 
	    }
    }
    
    if ($parent_id === -1)
    {
    	$TF->db->where('parent_id = cat_id OR parent_id = 0');
    }
    else {
	    
	    if ($include_parent) {
		    $TF->db->where('parent_id = '.$parent_id);
	    }
	    else 
	    {
		    $TF->db->where('parent_id = '.$parent_id . ' AND parent_id != cat_id');
	    }
    }
    
    

    $query = $TF->db->get();
	
	$options = array();
	
	if ($query->num_rows() > 0) {
		foreach ($query->result_array() as $row) {
			$options[$row['cat_id']] = $row['cat_name'];
		}
	}

    return $options;
}

function get_category_options() {
	
	$categories = get_categories();
	$options = array();
	foreach ($categories as $cat_id => $cat_name) {
		$child = get_categories($cat_id);
		
		if (!$child) {
			$child = array($cat_id => $cat_name);
		}
		
		$options[$cat_name] = $child;
	}
	
	
	return $options;
}

function get_category_options_2($indent='&#8594;&nbsp;') {
	
	$categories = get_categories();
	$options = array();
	foreach ($categories as $cat_id => $cat_name) {
		$child = get_categories($cat_id);
		
		$options[$cat_id] = $cat_name;
		foreach($child as $cat_id_2 => $cat_name_2) {
			$options[$cat_id_2] = $indent.$cat_name_2;
		}
	}
	
	return $options;
}

function get_parent_categories() {
	$TF = get_instance();
	$TF->db->select('categories.*');
	$TF->db->from('categories');
	
	if ($TF->session->userdata('location')) {
		$locations = $TF->session->userdata('location');
		$locations[] = 0;
		$TF->db->where_in('categories.location_id', $locations);
	}
	
	$TF->db->where('categories.parent_id = categories.cat_id OR categories.parent_id=0');
	
	$categories = $TF->db->get();
	
	return $categories->result_array();
}

function get_item($item_id) {
    $TF = get_instance();
    $TF->db->select('items.*');
    $TF->db->from('items');
    $TF->db->where('item_id', $item_id);
    $query = $TF->db->get();

    if ($query->num_rows() > 0) {
        $item = $query->row_array();
        $TF->db->select('facilities.*');
        $TF->db->from('facilities');
        $TF->db->join('items_related_facilities', 'items_related_facilities.facility_id = facilities.facility_id');
        $TF->db->where('items_related_facilities.item_id', $item_id);
        $query = $TF->db->get();
        $facilities = array();
        if ($query->num_rows() > 0)
            $facilities = $query->result_array();

        $item['related_facilities'] = $facilities;
        return $item;
    }

    return array();
}