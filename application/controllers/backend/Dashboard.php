<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends TF_Controller {

	function index() {
		
		
		$params = array();
        $params['locations'] = $this->session->userdata('location_id');

        $this->load->library('Eventsbuilder');
		$sales = $this->eventsbuilder->build_sales($params);
		
		$data['yesterday'] = date('Y-m-d', strtotime('-1 day'));
		
		$data['today'] = date('Y-m-d');

		$data['sales'] = $sales;
		
		$data['providers'] = get_available_providers(date('Y-m-d'), $this->session->userdata('location_id')); // get_provider_list(false, false, false, $this->session->userdata('location_id'));
		
		$this->db->select('contacts.first_name, contacts.last_name, bookings.booking_id, items.title as room_name, contacts.contact_id, package_types.package_type_name');
		$this->db->from('contacts');
		$this->db->join('bookings', 'bookings.guest_id = contacts.contact_id');
		$this->db->join('packages', 'bookings.package_id = packages.package_id', 'left');
		$this->db->join('package_types', 'package_types.package_type_id = packages.package_type_id', 'left');
		$this->db->join('items', 'bookings.room_id = items.item_id', 'left');
		$this->db->where(sprintf('\'%s\' BETWEEN FROM_UNIXTIME(tf_bookings.start_date) AND FROM_UNIXTIME(tf_bookings.end_date)', date('Y-m-d')));

		$query = $this->db->get();

		$bookings = $query->result_array();
		
		$by_package_types = array();
		foreach ($bookings as $row) {
			$type = $row['package_type_name'];
			if ($type === NULL) $type = 'Personalized';
			
			$by_package_types[$type][] = $row;
		}
		
		$data['bookings_by_package'] = $by_package_types;
		
		$data['bookings'] = $bookings;
		
		$inline_js = array(
			'defaultView' => 'agendaDay',
			'start_date' => date('Y-m-d'),
			'editable' => current_user_can('can_assign_schedules'),
			'droppable' => false,
			'resource_name' => '',
			'header' => array(
                'left' => 'prev, next',
                'center' => 'title',
                'right' => 'agendaDay,agendaWeek,month',
            ),
            'categories' => array(1, 2),
            'showGuestName' => true,
            'abbreviate' => true,
            'businessHours' => false,
            'minTime' => site_pref('start_time'),
            'maxTime' => site_pref('end_time'),
            'show_my_appointments' => true,
		);
		
		$data['inline_js'] = $inline_js;
		
		$q = $this->db->get('package_types');
		$data['package_types'] = $q->result_array();
		
		$group = get_current_user_group();
		
		if ($group['dashboard_top'] !== '') $data['dashboard_top'] = explode(',', trim($group['dashboard_top']));
		if ($group['dashboard_middle'] !== '') $data['dashboard_middle'] = explode(',', trim($group['dashboard_middle']));
		if ($group['dashboard_bottom'] !== '') $data['dashboard_bottom'] = explode(',', trim($group['dashboard_bottom']));
		
		$this->load->view('admin/dashboard', $data);
	}
	
}