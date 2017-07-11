<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends TF_Controller {

	public function index() {
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}

		$group_id = (int)$this->input->get_post('group_id');
		$dashboard_top = $this->input->get_post('dashboard_top');
		$dashboard_middle = $this->input->get_post('dashboard_middle');
		$dashboard_bottom = $this->input->get_post('dashboard_bottom');
		
		$location = $this->input->get_post('location');
		$locations = array();
		if ($location) {
			foreach ($location as $id => $yn) {
				if ($yn === 'y') {
					$locations[] = $id;
				}
			}
		}
		
		$f = $this->input->get_post('forms');
		$forms = array();
		if ($f) {
			foreach ($f as $id => $yn) {
				if ($yn === 'y') {
					$forms[] = $id;
				}
			}
		}

		$data = array(
			'group_name' => $this->input->get_post('group_name'),
			'include_in_audit_list' => $this->input->get_post('include_in_audit_list'),
			'include_in_provider_list' => $this->input->get_post('include_in_provider_list'),
			'can_delete_services' => $this->input->get_post('can_delete_services'),
			'can_edit_services' => $this->input->get_post('can_edit_services'),
			'can_admin_guest' => $this->input->get_post('can_admin_guest'),
			'can_admin_calendar' => $this->input->get_post('can_admin_calendar'),
			'can_admin_providers' => $this->input->get_post('can_admin_providers'),
			'can_admin_services' => $this->input->get_post('can_admin_services'),
			'can_admin_facilities' => $this->input->get_post('can_admin_facilities'),
			'can_admin_packages' => $this->input->get_post('can_admin_packages'),
			'can_admin_activities' => $this->input->get_post('can_admin_activities'),
            'can_view_other_profiles' => $this->input->get_post('can_view_other_profiles'),
            'can_edit_completed_forms' => $this->input->get_post('can_edit_completed_forms'),
            'can_assign_schedules' => $this->input->get_post('can_assign_schedules'),
            'can_view_other_schedule' => $this->input->get_post('can_view_other_schedule'),
            'can_edit_other_profiles' => $this->input->get_post('can_edit_other_profiles'),
            'can_manage_guest_bookings' => $this->input->get_post('can_manage_guest_bookings'),
            'can_manage_guest_forms' => $this->input->get_post('can_manage_guest_forms'),
            'can_manage_guest_settings' => $this->input->get_post('can_manage_guest_settings'),
            'can_view_dashboard' => $this->input->get_post('can_view_dashboard'),
            'can_view_today_bookings' => $this->input->get_post('can_view_today_bookings'),
            'can_add_schedule' => $this->input->get_post('can_add_schedule'),
			'location' => implode(',', $locations),
			'forms' => implode(',', $forms),
			'dashboard_top' => $dashboard_top ? implode(',', $dashboard_top) : '',
			'dashboard_middle' => $dashboard_middle ? implode(',', $dashboard_middle) : '',
			'dashboard_bottom' => $dashboard_bottom ? implode(',', $dashboard_bottom) : '',
		);

		$this->load->dbforge();

		foreach (get_all_locations() as $location) {
			$field = 'can_view_schedules_'.$location['location_id'];
			if (!$this->db->field_exists($field, 'groups')) {
				$this->dbforge->add_column('groups', array($field => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n')));
			}

			$data[$field] = $this->input->get_post($field);

			$field = 'can_edit_schedules_'.$location['location_id'];
			if (!$this->db->field_exists($field, 'groups')) {
				$this->dbforge->add_column('groups', array($field => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n')));
			}

			$data[$field] = $this->input->get_post($field);
		}

		if ($group_id) {
			$this->db->update('groups', $data, 'group_id = '.$group_id);
		}
		else {
			$this->db->insert('groups', $data);
		}

		redirect('backend/groups');
	}

	public function edit()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}

		$group_id = (int)$this->uri->segment(4);

		$data = array();

		if ($group_id) {
			$group = $this->db->get_where('groups', 'group_id=' . $group_id)->row_array();
			$group['location'] = explode(',', $group['location']);
			$group['forms'] = explode(',', $group['forms']);
			$group['dashboard_top'] = explode(',', $group['dashboard_top']);
			$group['dashboard_middle'] = explode(',', $group['dashboard_middle']);
			$group['dashboard_bottom'] = explode(',', $group['dashboard_bottom']);

			foreach (get_all_locations() as $location) {
				$group['can_view_schedules_'.$location['location_id']] = isset($group['can_view_schedules_'.$location['location_id']]) ? $group['can_view_schedules_'.$location['location_id']] : 'n';
				$group['can_edit_schedules_'.$location['location_id']] = isset($group['can_edit_schedules_'.$location['location_id']]) ? $group['can_edit_schedules_'.$location['location_id']] : 'n';
			}
		}
		else {

			$group = array(
				'group_id' => 0,
				'group_name' => '',
				'include_in_provider_list' => 'n',
				'can_delete_services' => 'n',
				'can_edit_services' => 'n',
				'can_admin_guest' => 'n',
				'can_admin_calendar' => 'n',
				'can_admin_providers' => 'n',
				'can_admin_services' => 'n',
				'can_admin_facilities' => 'n',
				'can_admin_packages' => 'n',
				'can_admin_activities' => 'n',
				'can_view_other_profiles' => 'n',
                'can_view_other_schedule' => 'n',
                'can_assign_schedules' => 'n',
                'can_add_schedule' => 'n',
                'include_in_audit_list' => 'n',
                'can_edit_completed_forms' => 'n',
                'can_edit_other_profiles' => 'n',
                'can_manage_guest_bookings' => 'n',
                'can_manage_guest_forms' => 'n',
                'can_view_dashboard' => 'n',
                'can_view_today_bookings' => 'n',
                'can_manage_guest_settings' => 'n',
				'location' => array(),
				'forms' => array(),
				'dashboard_top' => array(),
				'dashboard_bottom' => array(),
				'dashboard_middle' => array(),
			);

			foreach (get_all_locations() as $location) {
				$group['can_view_schedules_'.$location['location_id']] = 'n';
				$group['can_edit_schedules_'.$location['location_id']] = 'n';
			}

		}
		
		$available_widgets = array(
			'staff_for_today' => 'Staff For Today',
			'my_calendar' => 'My Calendar',
			'guest_for_today' => 'Guest For Today',
			'number_of_treatments' => 'Number of Treatments',
			'sales_for_today' => 'Sales For Today',
			'number_of_rooms' => 'Number of Rooms',
			'sales' => 'Projected Sales',
		);
		
		$forms = $this->db->get('forms')->result_array();

		$data['widgets'] = $available_widgets;
		$data['all_forms'] = $forms;
		$data['group'] = $group;

		$this->load->view('admin/group/form', $data);
	}
}
