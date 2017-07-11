<?php

class ProviderAvailability {
	
	var $start_date;
	var $end_date;
	
	var $item_id;
	
	var $TF;
	
	var $select = array(
		'contacts.contact_id', 
		'first_name', 
		'last_name', 
		'nickname', 
		'position'
	);
	
	public function __construct($params) {
		
		$this->TF =& get_instance();
		
		foreach ($params as $key => $value) {
            $this->$key = $value;
        }
	}
	
	public function validate() {
		
	}
	
	public function get_available() {	
			
		$check_in = $this->start_date;
		$check_out = $this->end_date;
		
		$this->TF->db->distinct();
		$this->TF->db->select(implode(', ', $this->select));
		$this->TF->db->from('user_work_plan_time');
		$this->TF->db->join('contacts', 'user_work_plan_time.contact_id = contacts.contact_id');
		$this->TF->db->join('users', 'users.contact_id = contacts.contact_id');
        $this->TF->db->join('groups', 'groups.group_id = users.group_id');
        $this->TF->db->join('items_related_users', 'contacts.contact_id = items_related_users.contact_id');
        if ($this->TF->session->userdata('location_id') !== 0) {
            $this->TF->db->where('users.location_id IN (0, '.$this->TF->session->userdata('location_id').')');
        }
        
        if ($this->item_id) {
	        $this->TF->db->where('items_related_users.item_id', $this->item_id);
        }
	        
        $this->TF->db->where('groups.include_in_provider_list = "y"');        
		$this->TF->db->where("((start_date BETWEEN '$check_in' AND '$check_out') OR (end_date BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN start_date AND end_date))");
		$this->TF->db->order_by('users.order', 'asc');

		$q = $this->TF->db->get();

		return $q->result_array();
	}
	
	public function get_available_time() {	
			
		$check_in = $this->start_date;
		$check_out = $this->end_date;
		
		$select = array_merge($this->select, array('user_work_plan_time.start_date', 'user_work_plan_time.end_date'));
		
		$this->TF->db->distinct();
		$this->TF->db->select(implode(', ', $select));
		$this->TF->db->from('user_work_plan_time');
		$this->TF->db->join('contacts', 'user_work_plan_time.contact_id = contacts.contact_id');
		$this->TF->db->join('users', 'users.contact_id = contacts.contact_id');
        $this->TF->db->join('groups', 'groups.group_id = users.group_id');
        $this->TF->db->join('items_related_users', 'contacts.contact_id = items_related_users.contact_id');
        if ($this->TF->session->userdata('location_id') !== 0) {
            $this->TF->db->where('users.location_id IN (0, '.$this->TF->session->userdata('location_id').')');
        }
        
        if ($this->item_id) {
	        $this->TF->db->where('items_related_users.item_id', $this->item_id);
        }
	        
        $this->TF->db->where('groups.include_in_provider_list = "y"');        
		$this->TF->db->where("((start_date BETWEEN '$check_in' AND '$check_out') OR (end_date BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN start_date AND end_date))");
		$this->TF->db->order_by('user_work_plan_time.start_date', 'asc');

		$q = $this->TF->db->get();	
					
		return $q->result_array();
	}
	
}