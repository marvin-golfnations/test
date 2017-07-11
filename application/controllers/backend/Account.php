<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends TF_Controller {

    public function index()
    {
        if (!$this->session->has_userdata('user_id'))
        {
            redirect('login');
        }

        if (!$_POST) return;

		$return = $this->input->get_post('return');
        $contact_id = $this->input->get_post('contact_id');
        $data = array(
            'first_name' => $this->input->get_post('first_name'),
            'last_name' => $this->input->get_post('last_name'),
            'title' =>  $this->input->get_post('title'),
            'email' =>  $this->input->get_post('email'),
            'civil_status' => $this->input->get_post('civil_status'),
            'nationality' => $this->input->get_post('nationality'),
            'country_dominicile' => $this->input->get_post('country_dominicile'),
            'etnic_origin' => $this->input->get_post('etnic_origin'),
            'dob' => date('Y-m-d', strtotime($this->input->get_post('dob'))),
            'age' => $this->input->get_post('age'),
            'gender' => $this->input->get_post('gender'),
            'height' => $this->input->get_post('height'),
            'weight' => $this->input->get_post('weight'),
            'phone' => $this->input->get_post('phone'),
            'nickname' => $this->input->get_post('nickname'),
            'position' => $this->input->get_post('position'),
            'date_joined' => date('Y-m-d', strtotime($this->input->get_post('date_joined'))),
        );

        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name','First name','required');
        $this->form_validation->set_rules('last_name','Last name','required');
        //$this->form_validation->set_rules('email','Email','required');

        if($this->form_validation->run()==TRUE){

            $config = get_upload_config(1);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('avatar')) {
                $file = $this->upload->data();
                $data['avatar'] = $config['url'].'/'.$file['file_name'];
            }
            else {
                $this->session->set_flashdata('error_message', $this->upload->display_errors('', ''));
            }

            if ($contact_id) {
                $this->db->update('contacts', $data, array('contact_id' => $contact_id));
            }
            else {

                $key = hash('md5', time());
                $data['verification_key'] = $key;

                $this->db->insert('contacts', $data);
                $contact_id = $this->db->insert_id();


                if (!isset($_REQUEST['skip_confirmation']) && !empty($data['email'])) {
                    $this->load->library('email');

                    $this->email->from($this->session->userdata('email'),  $this->session->userdata('screen_name'));
                    $this->email->to($data['email']);


                    $this->email->subject('Verify your TheFarm account');
                    $this->email->message(
                        'Hi '.$data['first_name'].' ' .$data['last_name'].", \n\n\n".
                        'Welcome to TheFarm! '."\n\n".
                        'Please complete your account by verifying your email address.'."\n\n".
                        '<a href="'.site_url('register/verify/'.$contact_id.'/'.$key).'">VERIFY EMAIL</a>'."\n\n".
                        'If the link above doesn\'t work, you can copy and paste the following into your browser:'."\n".
                        site_url('register/verify/'.$contact_id.'/'.$key)
                    );

                    $this->email->send();
                }
            }

            $this->session->set_flashdata('success_message', 'Profile has been successfully saved.');

            redirect('backend/account/edit/'.$contact_id.'?return='.$return);
        }else{
            echo "Missing field required.Please try again";
        }
    }



    public function edit() {

        if ($this->uri->segment(4) === FALSE)
        {
            $contact_id = 0;
        }
        else
        {
            $contact_id = (int)$this->uri->segment(4);
        }

        if (!current_user_can('can_view_other_profiles') && get_current_user_id() !== $contact_id && is_guest()) {
            show_error('Page Not Found!');
        }

        $booking_id = $this->uri->segment(4);

        $data = array();
        $data['contact_id'] = $contact_id;
        $data['booking_id'] = $booking_id;

        $inner_s = "SELECT bookings.booking_id 
                    FROM tf_bookings bookings 
                    WHERE bookings.guest_id = tf_contacts.contact_id AND bookings.status = 'confirmed'";

        $inner_s .= 'LIMIT 1';

        $this->db->select('users.*, contacts.*, groups.include_in_provider_list, ('.$inner_s.') as recent_booking');
        $this->db->from('contacts');
        $this->db->join('users', 'users.contact_id = contacts.contact_id', 'left');
        $this->db->join('groups', 'users.group_id = groups.group_id', 'left');
        $this->db->where('contacts.contact_id = ', $contact_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data['account'] = $query->row_array();
        }
        else {
            $data['account'] = array(
                'first_name' => '',
                'last_name' => '',
                'dob' => '',
                'age' => '',
                'gender' => '',
                'date_joined' => date('Y-m-d', now()),
                'nationality' => 'Filipino',
                'country_dominicile' => 'PH',
                'username' => '',
                'avatar' => '',
                'etnic_origin' => '',
                'civil_status' => '',
                'height' => '',
                'weight' => '',
                'phone' => '',
                'email' => '',
                'title' => '',
                'position' => '', //edited
                'recent_booking' => 0,
                'group_id' => 5, //Guest,
                'work_plan' => '',
                'last_login' => 0,
                'contact_id' => 0,
                'nickname' => '',
                'include_in_provider_list' => 'n'
            );
        }
        
        $data['titles'] = array(
        'Ms' => 'Ms',
		'Mrs' => 'Mrs',
		'Mr' => 'Mr',
		'Master' => 'Master',
		'Rev' => 'Rev',
		'Fr' => 'Fr',
		'Dr' => 'Dr',
		'Atty' => 'Atty',
		'Prof' => 'Prof',
		'Hon' => 'Hon',
		'Pres' => 'Pres',
		'Gov' => 'Gov',
		'Coach' => 'Coach',
		'Ofc' => 'Ofc',
		'Rep' => 'Rep',
		'Sen' => 'Sen');
		
		$data['civil_statuses'] = array(
		'Single' => 'Single',
		'Married' => 'Married',
		'Living Common Law' => 'Living Common Law',
		'Widowed' => 'Widowed',
		'Separated' => 'Separated',
		'Divorced' => 'Divorced',
		);

        $data['group_id'] = $data['account']['group_id'];

        $data['bookings'] = get_bookings($contact_id);

        $confirmed_bookings = get_bookings($contact_id, 'confirmed');

        $data['confirmed_bookings'] = $confirmed_bookings;

        $data['statuses'] = get_statuses(1);

        $data['nationality'] = $data['account']['nationality'] === '' ? 'Filipino' : $data['account']['nationality'];

        $data['nationalities'] = nationalities();

        $data['countries'] = countries();

        $this->db->select('items.*, items_related_users.contact_id');
        $this->db->from('items');
        $this->db->join('items_related_users', 'items.item_id = items_related_users.item_id', 'left');
        $this->db->where('contact_id = '.$contact_id);
        $q = $this->db->get();

        $related_services = array();
        $exclude = array();
        if ($q->num_rows()) {
            $related_services = $q->result_array();
            foreach ($related_services as $service) {
                $exclude[] = $service['item_id'];
            }
        }

        $data['related_services'] = $related_services;

        $other_services = get_services(false, $exclude);
        $other = array();
        foreach ($other_services as $service) {
	        $duration = (int)$service['duration'];
            $other[$service['cat_name']][$service['item_id']] = $service['title'] . ($duration > 0 ? ' ('.$duration . ' min)' : '');
        }

        $data['other_services'] = $other;

        $q = $this->db->get_where('messages', array('receiver' => $contact_id));
        $data['messages'] = $q->result_array();

        $start_date = time();
        $end_date = time();
        $number_of_days = 1;
        $booking_id = 0;
        $view = '';
        if ($confirmed_bookings) {
            $booking = $confirmed_bookings[0];
            $booking_id = (int)$booking['booking_id'];
            $start_date = $booking['start_date'];
            $end_date = $booking['end_date'];
            $start_date_dt = new DateTime(date('c', $start_date));
            $end_date_dt = new DateTime(date('c', $end_date));
            $diff = $start_date_dt->diff($end_date_dt);
            $number_of_days = (int)$diff->days;
            $view = $number_of_days > 0 ? 'agenda' . ($number_of_days+1) . 'Days' : 'agendaWeek';
        }

        $data['booking_id'] = $booking_id;
        
        $this->db->select('booking_events.*, items.description, facilities.bg_color, items.title as item_name, items.duration, facilities.facility_name, contacts.first_name, contacts.last_name, contacts.nickname');
        $this->db->from('booking_events');
        $this->db->join('items', 'items.item_id = booking_events.item_id');
        $this->db->join('item_categories', 'items.item_id = item_categories.item_id');
        $this->db->join('facilities', 'facilities.facility_id = booking_events.facility_id', 'left');
        $this->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id', 'left');
        $this->db->join('contacts', 'contacts.contact_id = booking_event_users.staff_id', 'left');
        $this->db->where_in('item_categories.category_id', array(4, 9));
        $this->db->where('booking_events.deleted', 'n');
		$this->db->order_by('booking_events.start_dt', 'asc');
		$results = $this->db->get();
        $data['activities'] = $results->result_array();
        
        $categories = array(1,2,3,12); //get_category_options_2('&nbsp;');
        
        $data['categories'] = array(); //$categories;
        
        $locations = array();
        foreach (get_locations() as $location_id => $location_name) {
            if (current_user_can('can_view_schedules_' . $location_id)) {
                $locations[] = (int)$location_id;
            }
        }

        $view_name = 'agenda'.($number_of_days+1).'Days';

        $inline_js = array(
            'showGuestName' => false,
            'showFacility' => true,
            'abbreviate' => true,
            'resource_field_id' => 'contact_id',
            'businessHours' => false,
            'defaultView' => 'month',
            'start_date' => date('Y-m-d'),
            'minTime' => site_pref('start_time'),
            'maxTime' => site_pref('end_time'),
            'booking_id' => $booking_id,
            'droppable' => true,
            'show_providers' => true,
            'header' => array(
                'left' => 'prev, next, today, treatments, nutritionals',
                'center' => 'title',
                'right' => 'month,'.$view_name,
            ),
            'guest_name' => $data['account']['title'] . '. '.$data['account']['first_name'] . ' ' . $data['account']['last_name'],
            'views' => array(
                $view_name => array(
                    'type' => 'agenda',
                    'duration' => array('days' => $number_of_days + 1),
                    'start_date' => date('c', $start_date),
                    'buttonText' => ($number_of_days+1) . ' day(s)')
            ),
            'categories' => array(1, 2, 3, 12),
            'viewFullDetails' => true, //!tf_current_user_can('edit_calendar'),
            'canChange' => current_user_can('can_add_schedule'),
            'user_id' => $this->session->userdata('user_id'),
            'show_providers' => false,
        );

        
        $data['inline_js'] =  $inline_js; /*array(
			'print_url' => site_url('backend/account/print_schedule'),
			'positions' => array(),
			'showGuestName' => false,
			'showFacility' => false,
			'abbreviate' => false,
			'editable' => true,
			'resource_field_id' => '',
			'businessHours' => false,
			'defaultView' => 'month',
			'start_date' => date('Y-m-d', $start_date),
			'end_date' => date('Y-m-d', $end_date),
			'minTime' => site_pref('start_time'),
			'maxTime' => site_pref('end_time'),
			'droppable' => true,
			'show_providers' => false,

			'guest_name' => $data['account']['title'] . '. '.$data['account']['first_name'] . ' ' . $data['account']['last_name'],
			'viewFullDetails' => true, //!tf_current_user_can('edit_calendar'),
			'canChange' => true,
			'statuses' => array(),
			'user_id' => $this->session->userdata('user_id'),
			'selected_locations' => $locations,
			'booking_id' => $booking_id,
			'categories' => $categories,
		);*/
        
        if ($this->input->get_post('back')) {
            $data['back'] = $this->input->get_post('back');
        }
        else {
            $data['back'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('contacts');
        }
			
		$editable = false;
		
		if ($this->session->userdata('user_id') === $data['account']['group_id']) {
			$editable = true;
		}
		elseif (current_user_can('can_edit_other_profiles')) {
			$editable = true;
		}
		
		$data['editable'] = $editable;
		$data['return'] = $this->input->get_post('return') ? $this->input->get_post('return') : 'contacts';
        $data['booking_items'] = booking_items($data['booking_id'], 'confirmed', true);
        if (is_guest()) {
            $this->load->library('FormBuilder');
            if ($booking_id > 0) {
	            $data['booking'] = $booking;
							$data['forms'] = booking_forms($booking_id, 'n');
						}
						else {
							$data['forms'] = false;
							$data['booking'] = false;
						}
            $this->load->view('admin/account/guest', $data);
        }
        else {
			
			$this->load->library('FormBuilder');
			
            $this->db->select('contacts.*, forms.*, bookings.*, booking_forms.*');
            $this->db->from('booking_forms');
            $this->db->join('bookings', 'booking_forms.booking_id = bookings.booking_id');
            $this->db->join('forms', 'booking_forms.form_id = forms.form_id');
            $this->db->join('contacts', 'booking_forms.completed_by = contacts.contact_id', 'left');
            $this->db->where('bookings.guest_id', $contact_id);
            $query = $this->db->get();
            $data['guest_forms'] = $query->result_array();
            $data['work_plan'] = isset($data['account']['work_plan']) ? unserialize($data['account']['work_plan']) : '';
            $this->load->view('admin/account/form', $data);
        }
    }

    public function calendar() {
        $this->load->view('admin/account/calendar-popup');
    }

    public function event() {

        $event_id = (int)$this->input->get_post('id');
        $startDate = $this->input->get_post('start');
        $item_id = (int)$this->input->get_post('item_id');
        $booking_id = (int)$this->input->get_post('booking_id');
        $assigned_to = (int)$this->input->get_post('assigned_to');
        $duration = (int)$this->input->get_post('duration');
        $booking_item_id = (int)$this->input->get_post('booking_item_id');

        if ($duration === 0) $duration = 60;

        $start_date_dt = new DateTime($startDate);
        $end_date_dt = new DateTime($startDate);
        $end_date_dt->add(new DateInterval('PT'.$duration.'M'));
       

        $event_data = array(
            'guest_id' => 0,
            'facility_id' => 0,
            'status' => '',
            'called_by' => 0,
            'cancelled_by' => 0,
            'cancelled_reason' => '',
            'date_cancelled' => now(),
            'max_provider' => 1,
            'duration' => 30,
            'author_id' => $this->session->userdata('user_id'),
            'booking_id' => $booking_id,
            'item_id' => $item_id,
            'start_dt' => $start_date_dt->format('Y-m-d H:i:s'),
            'end_dt' => $end_date_dt->format('Y-m-d H:i:s'),
            'event_title' => $this->input->get_post('event_title'),
            'notes' => $this->input->get_post('notes'),
            'included' => 0,
            'not_included' => 0,
            'foc' => 0
        );


        if($event_id) {

            $this->db->select('booking_events.*, items.duration, items.max_provider, 
                bookings.booking_id, bookings.guest_id, booking_events.notes, 
                booking_items.item_id, booking_items.included, booking_items.foc, 0 as not_included');
            $this->db->from('booking_events');
            $this->db->join('booking_items', 'booking_events.booking_item_id = booking_items.booking_item_id', 'left');
            $this->db->join('bookings', 'bookings.booking_id = booking_items.booking_id', 'left');
            $this->db->join('items', 'booking_items.item_id=items.item_id', 'left');
            $this->db->where('event_id = ', $event_id);
            $query = $this->db->get();
            $event_data = $query->row_array();
            
            $query->free_result();
        }

        $date_cancelled = (int)$event_data['date_cancelled'] === 0 ? now() : (int)$event_data['date_cancelled'];

        $booking_id = (int)$event_data['booking_id'];
        $data = array(
            'guest_id' => (int)$event_data['guest_id'],
            'event_id' => (int)$event_id,
            'author_id' => (int)$event_data['author_id'],
            'item_id' => (int)$event_data['item_id'],
            'facility_id' => (int)$event_data['facility_id'],
            'booking_id' => $booking_id,
            'status' => $event_data['status'],
            'event_title' => $event_data['event_title'],
            'called_by' => (int)$event_data['called_by'],
            'cancelled_by' => (int)$event_data['cancelled_by'],
            'cancelled_reason' => $event_data['cancelled_reason'],
            'notes' => $event_data['notes'],
            'duration' => (int)$event_data['duration'],
            'max_provider' => (int)$event_data['max_provider'],
            'date_cancelled' => date('m/d/Y', $date_cancelled),
            'start_date' => date('Y-m-d', strtotime($event_data['start_dt'])),
            'start_time' => date('H:i', strtotime($event_data['start_dt'])),
            'end_date' => date('Y-m-d', strtotime($event_data['end_dt'])),
            'end_time' => date('H:i', strtotime($event_data['end_dt'])),
            'included' => $event_data['included'],
            'foc' => $event_data['foc'],
            'not_included' => $event_data['not_included'],
        );
        
        $data['assigned_to'] = $assigned_to;
        
        if ($event_id > 0) {

	        $query = $this->db->get_where('booking_event_users', 'event_id='.$event_id);
	        $assigned_to = array();
	        if ($query->num_rows() > 0) {
	            foreach ($query->result_array() as $row) {
	                $assigned_to[] = (int)$row['staff_id'];
	            }
	        }
			$query->free_result();
	        $data['assigned_to'] = $assigned_to;
        }

        $facilities = array('' => '');

        $this->db->select('facility_id, facility_name');
        $this->db->from('facilities');
        $this->db->where('facilities.status', 1);
        if ($this->session->userdata('location'))
        {
            $this->db->where_in('facilities.location_id', $this->session->userdata('location'));
        }

		$query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $facilities[$row['facility_id']] = $row['facility_name'];
        }
		$query->free_result();
        $params = array();
        $params['start'] = date('Y-m-d H:i:s', strtotime($event_data['start_dt']));
        $params['end'] = date('Y-m-d H:i:s', strtotime($event_data['end_dt']));
        $params['event'] = (int)$event_id;
        $params['status'] = $event_data['status'];
        $params['item_id'] = (int)$event_data['item_id'];
        $params['booking_id'] = $booking_id;
        $params['exclude_peoples'] = array();
        $params['exclude_facilities'] = array();
        $params['exclude_status'] = array();
        $params['people'] = $assigned_to ? $assigned_to[0] : false;

        $this->load->library('availability', $params);
        $this->availability->validate();

		$select_facility = array(0 => '-Select-');

        $facilities = keyval($this->availability->get_available_facilities(), 'facility_id', 'facility_name', false, $select_facility);
        $data['facilities'] = $facilities;
        
        $params = array(
			'start_date' => date('Y-m-d H:i:s', strtotime($event_data['start_dt'])),
			'end_date' => date('Y-m-d H:i:s', strtotime($event_data['end_dt'])),
			'item_id' => (int)$event_data['item_id']
		);
		
		$this->load->library('ProviderAvailability', $params);
	
		$select_provider = array(0 => '-Select-');
        $providers = keyval($this->provideravailability->get_available(), 'contact_id', array('first_name', 'last_name'), 'position', $select_provider);
        $data['providers'] = $providers;

        $statuses = array_merge(array('' => '-Select-'), get_statuses(2));
        $data['statuses'] = $statuses;
		$data['dates'] = array();
		if ($booking_id === 0) {
			
			$bookings = array('' => '-Select-');
			$this->db->select('contacts.first_name, contacts.last_name, bookings.booking_id, packages.package_name');
			$this->db->from('contacts');
			$this->db->join('bookings', 'bookings.guest_id = contacts.contact_id');
			$this->db->join('packages', 'bookings.package_id = packages.package_id', 'left');
			$this->db->where(sprintf('\'%s\' BETWEEN FROM_UNIXTIME(tf_bookings.start_date) AND FROM_UNIXTIME(tf_bookings.end_date)', date('Y-m-d', strtotime($event_data['start_dt']))));
			$this->db->where('bookings.status', 'confirmed');

			$query = $this->db->get();


            foreach ($query->result_array() as $row) {
				$bookings[$row['booking_id']] = $row['first_name'] . ' ' . $row['last_name'] . ($row['package_name'] ? ' - ' . $row['package_name'] : '');
			}

            $endDate = new DateTime($_REQUEST['start']);
            $endDate->add(new DateInterval('P1W'));

            $date_range = createDateRangeArray($_REQUEST['start'], $endDate->format('Y-m-d'));
            $dates = array();
            foreach ($date_range as $date) $dates[$date] = date('m/d/Y', strtotime($date));

            $query->free_result();
            $data['dates'] = $dates;
			$data['bookings'] = $bookings;
		}
		else
		{
			$this->db->select('contacts.first_name, contacts.last_name, bookings.title, bookings.booking_id, bookings.start_date, bookings.end_date');
			$this->db->from('contacts');
			$this->db->join('bookings', 'bookings.guest_id = contacts.contact_id');
			$this->db->where('booking_id', $booking_id);
			$query = $this->db->get();
			$result = $query->row_array();
			
			$date_range = createDateRangeArray(date('Y-m-d', $result['start_date']), date('Y-m-d', $result['end_date']));
			$dates = array();
			foreach ($date_range as $date) $dates[$date] = date('m/d/Y', strtotime($date));
			
			$data['dates'] = $dates;
			$data['booking_data'] = $result;
			
			$query->free_result();
		}

		$query = $this->db->get('package_types');
		$package_types = array('' => '-Select Package-');
		foreach ($query->result_array() as $row) {
		    $package_types[$row['package_type_id']] = $row['package_type_name'];
        }

        $data['package_types'] = $package_types;

        $data['times'] = createTimeRangeArray(1800*12, 3600*23, 60*10);
        
        $data['booking_item_id'] = $booking_item_id;
        
        $data['reasons'] = array('Reason 1', 'Reason 2', 'Reason 3', 'N/A');

        $audit_users = array();
        $audit_users[get_current_user_id()] = 'Me';
        foreach (get_audit_users(array(get_current_user_id())) as $row) {
            $audit_users[$row['contact_id']] = $row['first_name'] . ' ' . $row['last_name'];;
        }

        $data['audit_users'] = $audit_users;

        $this->load->view('admin/account/event', $data);
    }

    public function save()
    {

    }

    public function register() {

    }

    public function check_name() {
        $query = $this->db->get_where('contacts', array('first_name' => $this->input->get_post('first_name'), 'last_name' => $this->input->get_post('last_name')));

        echo json_encode(array('result' => $query->row_array()));
    }

    public function error(){
        $this->view('admin/account', array('error'=>'required'));
    }

    public function login() {
        $contact_id = $this->input->get_post('contact_id');
        $return = $this->input->get_post('return');
        $query = $this->db->get_where('users',
            array(
                'username' => $this->input->get_post('username'),
                'contact_id != ' => $contact_id)
        );


        if ($query->num_rows() > 0) {
            $this->session->set_flashdata('error_message', 'Username already exists.');
            redirect('backend/account/edit/'.$contact_id);
        }
        else {

            $data = array();

            if ($this->input->get_post('password') &&
                $this->input->get_post('password') === $this->input->get_post('confirm_password')) {
                $data['password'] = do_hash($this->input->get_post('password'));
            }

            if (is_admin() && $group_id = $this->input->get_post('group_id')) {
                $data['group_id'] = $group_id;
            }

            if (is_admin() && $location_id = $this->input->get_post('location_id')) {
                $data['location_id'] = $location_id;
            }

            if ($this->input->get_post('new_password') &&
                $this->input->get_post('new_password') === $this->input->get_post('confirm_new_password')) {
                $data['password'] = do_hash($this->input->get_post('new_password'));
            }

            $data['username'] = $this->input->get_post('username');

            $query = $this->db->get_where('users', array('contact_id' => $contact_id));
            if ($query->num_rows() > 0)
                $this->db->update('users', $data,
                    array('contact_id' => $contact_id));
            else {

                $data['username'] = $this->input->get_post('username');
                $data['contact_id'] = $contact_id;

                $this->db->insert('users', $data);
            }
            redirect('backend/account/edit/'.$contact_id.'?return='.$return);
        }
    }

    public function delete() {

        $id = (int)$this->uri->segment(4);
        $confirm = $this->input->get_post('confirm');
        
        if ($id && $confirm && $confirm === 'y') {

           $this->db->update('contacts', array('deleted' => 1), array('contact_id' => $id));
			
// 			$this->db->delete('contacts', array('contact_id' => $id));
// 			$this->db->delete('users', array('contact_id' => $id));
// 			$this->db->delete('bookings', array('guest_id' => $id));

            if ($return = $this->input->get_post('return'))
                redirect($return);
        }

        redirect('backend/contacts');
    }

    public function dashboard() {
	    $this->db->select('booking_events.*, items.description, facilities.bg_color, items.title as item_name, items.duration, facilities.facility_name, contacts.first_name, contacts.last_name, contacts.nickname');
        $this->db->from('booking_events');
        $this->db->join('items', 'items.item_id = booking_events.item_id');
        $this->db->join('item_categories', 'items.item_id = item_categories.item_id');
        $this->db->join('facilities', 'facilities.facility_id = booking_events.facility_id', 'left');
        $this->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id', 'left');
        $this->db->join('contacts', 'contacts.contact_id = booking_event_users.staff_id', 'left');
        $this->db->where_in('item_categories.category_id', array(4, 9));
        $this->db->where('booking_events.deleted', 'n');
		$this->db->order_by('booking_events.start_dt', 'desc');
		$results = $this->db->get();
        $data['activities'] = $results->result_array();
        
        $params = array();
        $params['guest_id'] = get_current_user_id();
        $this->load->library('Eventsbuilder', $params);
		$this->eventsbuilder->build();
		
		
		$data['inline_js'] = array(
            'resources' => array(),
            'view' => 'agendaDay',
            'show_providers' => false,
            'editable' => false,
            'resource_field_id' => 'contact_id',
            'businessHours' => false,
            'defaultView' => 'agendaDay',
            'start_date' => date('Y-m-d'),
            'minTime' => site_pref('start_time'),
            'maxTime' => site_pref('end_time'),
            'showGuestName' => false,
			'showFacility' => false,
			'abbreviate' => false,
            'droppable' => false,
            'header' => array(
                'left' => 'prev, next, today',
                'center' => 'title',
                'right' => 'agendaDay, agendaWeek, month',
            ),
            'views' => array(),
            'guest_id' => get_current_user_id(),
            'show_my_appointments' => true,
            'show_off_providers' => false,
            'viewFullDetails' => true, //!tf_current_user_can('edit_calendar'),
            'canChange' => false,
            'statuses' => array(),
            'selected_statuses' => array(),
            'selected_positions' => array(),
        );
        
        $data['events'] = $this->eventsbuilder->get_events(); // get_events(false, false, 'contact_id', '', '', get_current_user_id(), array(2), array(2));
        $this->load->view('dashboard', $data);
    }

    public function sort() {
        $action = $this->uri->segment(4); //up or down
        $contact_id = (int)$this->uri->segment(4);
        $order = (int)$this->uri->segment(5);

        if ($action === 'up') {
            $order++;
        }
        else {
            $order--;
        }

        $this->db->query('UPDATE tf_users SET `order` = `order` + 1 WHERE contact_id = '.$contact_id);

        $this->load->library('user_agent');
        if ($this->agent->is_referral())
        {
            echo $this->agent->referrer();
        }
    }

    public function add() {
        $group_id = $this->uri->segment(4);

        if ($group_id !== 5) {
            $this->load->view('admin/user/form');
        }
    }
    
    public function user() {

        if (!$_POST) return;

        $group_id = $this->input->get_post('group_id');
        $first_name = $this->input->get_post('first_name');
        $last_name = $this->input->get_post('last_name');
        $email = $this->input->get_post('email');
        $username = $this->input->get_post('username');
        $location_id = $this->input->get_post('location_id');


        $query = $this->db->get_where('users', array('username' => $username));
        if ($query->num_rows() >= 1) {
            show_error('Username already exist!');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name','First name','required');
        $this->form_validation->set_rules('last_name','Last name','required');
        $this->form_validation->set_rules('email','Email','required');

        if($this->form_validation->run()==TRUE) {

            $this->db->insert('contacts', array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'verified' => 'y',
                'date_joined' => date('Y-m-d')
            ));
            $contact_id = $this->db->insert_id();

            $this->db->insert('users', array(
                'contact_id' => $contact_id,
                'username' => $username,
                'group_id' => $group_id,
                'location_id' => $location_id,
            ));

            if (!isset($_REQUEST['skip_confirmation'])) {
                $this->load->library('email');

                $this->email->from($this->session->userdata('email'),  $this->session->userdata('screen_name'));
                $this->email->to($email);

                $message = sprintf(
                    '%s'.":\n\n".
                    'You have been added by %s.'."\n\n".
                    'To view your list of assignments, login to your TheFarm account:'."\n\n".
                    '%s'."\n\n",
                    $first_name, $this->session->userdata('screen_name'), site_url());

                $user_group = get_user_group($group_id);

                $this->email->subject($this->session->userdata('screen_name').' has added you as '.$user_group['group_name']);
                $this->email->message($message);
                $this->email->send();
            }

            redirect('backend/account/edit/'.$contact_id);

        }
    }
    
    public function activate() {
	    $contact_id = (int)$this->input->get_post('contact_id');
	    $status = $this->input->get_post('status');
	    
	    $query = $this->db->get_where('contacts', array('contact_id' => $contact_id));
	    
	    if ($query->num_rows() > 0) {
		    $data = $query->row_array();
	    	$this->db->update('contacts', array('active' => $status), array('contact_id' => $contact_id));
	    	
	    	$text = 'DEACTIVATED';
		    
		    if ($status === 'y') $text = 'ACTIVATED';
		    
	    	$this->output->set_content_type('application/json');
	        echo json_encode(array('message' => $data['first_name'] . ' ' . $data['last_name'] . ' was <b>'.$text.'</b>.'));
	        die();
	    }   
    }
    
    public function verify() {
	    $contact_id = (int)$this->input->get_post('contact_id');
	    $status = $this->input->get_post('status');
	    
	    $query = $this->db->get_where('contacts', array('contact_id' => $contact_id));
	    
	    if ($query->num_rows() > 0) {
		    $data = $query->row_array();
		    $text = 'UNVERIFIED';
		    
		    if ($status === 'y') $text = 'VERIFIED';
		    
		    $data = $query->row_array();
	    	$this->db->update('contacts', array('verified' => $status), array('contact_id' => $contact_id));
	    	
	    	$this->output->set_content_type('application/json');
	        echo json_encode(array('message' => $data['first_name'] . ' ' . $data['last_name'] . ' was <b>'.$text.'</b>.'));
	        die();
	    }   

    }
    
    public function approve() {
	    $contact_id = (int)$this->input->get_post('contact_id');
	    $status = $this->input->get_post('status');
	    $query = $this->db->get_where('contacts', array('contact_id' => $contact_id));
	    
	    if ($query->num_rows() > 0) {
		    $data = $query->row_array();
		    
		    $code = rand(100000, 999999);
		    
			$text = 'DISAPPROVED';
		    if ($status === 'y') {
			    $text = 'APPROVED';
			    $this->db->update('contacts', array('approved' => $status, 'activation_code' => $code), array('contact_id' => $contact_id));    
			    $this->load->library('email');
				$this->email->from('jay_cruz@thefarm.com.ph', 'Jay');		
				$this->email->to($data['email']);
				$this->email->subject('Activation');
				$this->email->message('Code : <b>'.$code.'</b>');
			    $return = $this->input->get_post('return');		    
			}

			$this->output->set_content_type('application/json');
	        echo json_encode(array('message' => $data['first_name'] . ' ' . $data['last_name'] . ' was <b>'.$text.'</b>.'));
	        die();
		}
    }

    public function print_schedule() {
        $booking_id = (int)$this->uri->segment(4);
        $page = (int)$this->uri->segment(5);

        $this->db->select('contacts.*, bookings.title, bookings.start_date, bookings.end_date');
        $this->db->from('contacts');
        $this->db->join('bookings', 'bookings.guest_id = contacts.contact_id');
        $this->db->where('bookings.booking_id = '.$booking_id);
        $query = $this->db->get();
        $booking = $query->row_array();

        $begin = new DateTime(date('Y-m-d', (int)$booking['start_date']));
        $end = new DateTime(date('Y-m-d', (int)$booking['end_date']));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $dates = array();

        foreach ( $period as $dt ) {
            $dates[] = $dt;
        }

        $data = array();
        $data['booking_id'] = $booking_id;
        $data['booking'] = $booking;
        $data['dates'] = $dates;
        $data['begin'] = $begin;
        $data['end'] = $end;
	
		$params = array();
		$params['booking_id'] = $booking_id;
		$params['show_guest_name'] = false;
		$this->load->library('Eventsbuilder', $params);
		$this->eventsbuilder->build();
		
		$events = $this->eventsbuilder->get_events();
        $_events = array();

        foreach ($events as $event) {
            for ($i = strtotime($event['start']); $i < strtotime($event['end']); $i += 1800) {  // 1800 = half hour, 86400 = one day
                $tm = $i;

                $dt = date('Y-m-d', $i);

                $t = sprintf('%1$s', date('h:i A', $tm));
                $t2 = sprintf('%1$s', date('H:i', $tm));
                $_events[$dt][$t2] = $event;
            }
        }

        $this->load->library('Pdf');
        $mpdf = $this->pdf->load();

        $data['events'] = $_events;
        $data['duration'] = count($dates);

        $this->add_page($mpdf, $data, $dates, false, 0, 4, 1); // page 1
        $this->add_page($mpdf, $data, $dates, true, 4, 3); // page 2
        $this->add_page($mpdf, $data, $dates, false, 7, 4); // page 3
        $this->add_page($mpdf, $data, $dates, true, 11, 3); // page 4
        $this->add_page($mpdf, $data, $dates, false, 14, 4); // page 5
        $this->add_page($mpdf, $data, $dates, true, 18, 3); // page 6
        $this->add_page($mpdf, $data, $dates, false, 21, 4); // page 7
        $this->add_page($mpdf, $data, $dates, true, 25, 3); // page 8
        $this->add_page($mpdf, $data, $dates, false, 28, 4); // page 9
        $this->add_page($mpdf, $data, $dates, true, 32, 3); // page 10
        $this->add_page($mpdf, $data, $dates, false, 35, 4); // page 11

        $mpdf->SetTitle($booking['title']);
        $mpdf->Output();
    }

    private function add_page($mpdf, $data, $dates, $show_label, $start, $length, $day_start = null) {
        $dates_to_show = array_slice($dates, $start, $length);
        if ($dates_to_show) {
            $data['dates'] = $dates_to_show;
            $data['show_label'] = $show_label;
            $data['day_start'] = is_null($day_start) ? $start : $day_start;
            $html = $this->load->view('admin/account/print_schedule', $data, true);
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);
        }
    }
}
