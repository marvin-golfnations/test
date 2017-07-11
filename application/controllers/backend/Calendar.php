<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends TF_Controller
{


    public function index()
    {
        if (!$this->session->has_userdata('user_id')) {
            redirect('login');
        }

        if ($_POST) {
            $this->load->helper('event');
            $booking_id = (int)$this->input->get_post('booking_id');
            $event_id = (int)$this->input->get_post('event_id');
            $item_id = $this->input->get_post('item_id');
            $end_date = $this->input->get_post('end_date');
            $end_time = $this->input->get_post('end_time');
            $start_date = $this->input->get_post('start_date');
            $start_time = $this->input->get_post('start_time');
            $status = $this->input->get_post('status');
            $notes = $this->input->get_post('notes');
            $booking_item_id = (int)$this->input->get_post('booking_item_id');
            $event_title = $this->input->get_post('event_title') ? $this->input->get_post('event_title') : '';
            $included = (int)$this->input->get_post('included');
            $not_included = (int)$this->input->get_post('not_included');
            $foc = (int)$this->input->get_post('foc');

            $update_calendar_views = $this->input->get_post('update_calendar_views');

            if ($booking_id === 0) {
                // create the guest.
                $first_name = $this->input->get_post('first_name');
                $last_name = $this->input->get_post('last_name');
                $package_type = $this->input->get_post('package_type');
                $contact_id = $this->input->get_post('guest_id');
                if (!$contact_id) {
                    $this->db->insert('contacts', array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'date_joined' => date('Y-m-d')
                    ));
                    $contact_id = $this->db->insert_id();
                }
                $arrival = strtotime($this->input->get_post('arrival_date'));
                $departure = strtotime($this->input->get_post('departure_date'));
                $this->db->insert('bookings', array(
                    'guest_id' => $contact_id,
                    'title' => $first_name . ' ' . $last_name . ' Personalized Program',
                    'start_date' => $arrival,
                    'end_date' => $departure,
                    'author_id' => get_current_user_id(),
                    'entry_date' => now(),
                    'personalized' => 1,
                    'package_type_id' => $package_type,
                    'status' => 'confirmed',
                ));

                $booking_id = $this->db->insert_id();
            }

            $data = array(
                'all_day' => 0,
                'status' => $status,
                'event_title' => $event_title,
                'called_by' => 0,
                'cancelled_by' => 0,
                'cancelled_reason' => '',
                'date_cancelled' => 0,
                'notes' => $notes,
            );

            if ($status === 'cancelled') {
                $data['called_by'] = (int)$this->input->get_post('called_by');
                $data['cancelled_by'] = (int)$this->input->get_post('cancelled_by');
                $data['cancelled_reason'] = $this->input->get_post('cancelled_reason');
                $data['date_cancelled'] = strtotime($this->input->get_post('date_cancelled'));
            }

            $data['start_dt'] = date('c', strtotime($start_date . ' ' . $start_time));
            $data['end_dt'] = date('c', strtotime($end_date . ' ' . $end_time));

            if ($facility = $this->input->get_post('facility_id')) {
                $data['facility_id'] = $facility;
            }

            $assignedTo = array();
            if ($assignedTo = $this->input->get_post('assigned_to')) {
                if (!is_array($assignedTo)) $assignedTo = array((int)$assignedTo);
            }


//			Check if provider is available.
//			2) Get all confirmed events of the provider for that time.
//					provider + start time + end time
            $params = array();
            $params['room'] = isset($data['facility_id']) ? $data['facility_id'] : false;
            $params['people'] = $assignedTo;
            $params['start'] = date('Y-m-d H:i:s', strtotime($data['start_dt']));
            $params['end'] = date('Y-m-d H:i:s', strtotime($data['end_dt']));
            $params['event'] = $event_id;
            $params['status'] = $status;
            $params['booking_id'] = $booking_id;
            $params['item_id'] = $item_id;
            $params['exclude_status'] = array('cancelled', 'completed', 'no show');

            $this->load->library('availability', $params);
            if (!$this->availability->validate()) {
                $this->availability->display_errors();
            }

            if ($booking_item_id) {
                $data['booking_item_id'] = $booking_item_id;
            } else {
                if ($item_id) {
                    //select if the item is in the package.
                    $this->db->select('booking_item_id, inventory');
                    $this->db->from('booking_items');
                    $this->db->where('item_id = ' . $item_id);
                    $this->db->where('booking_id = ' . $booking_id);
                    $this->db->where('inventory > 0');

                    $query = $this->db->get();
                    if ($query->num_rows() > 0) {
                        $row = $query->row_array();
                        $data['booking_item_id'] = $row['booking_item_id'];
                    } else {
                        $this->db->insert('booking_items', array(
                            'booking_id' => $booking_id,
                            'item_id' => $item_id,
                            'quantity' => 1,
                            'included' => $included,
                            'foc' => $foc,
                            'upsell' => $status === 'foc' ? 0 : 1
                        ));
                        $data['booking_item_id'] = $this->db->insert_id();
                    }
                } else {
                    $this->db->insert('booking_items', array(
                        'booking_id' => $booking_id,
                        'item_id' => $item_id,
                        'quantity' => 1,
                        'included' => $included,
                        'foc' => $foc,
                    ));
                    $data['booking_item_id'] = $this->db->insert_id();
                }
            }

            $event_users = array();

            if ($event_id) {
                $data['edit_date'] = now();
                $this->db->update('booking_events', $data, array('event_id' => $event_id));
                $this->db->delete('booking_event_users', 'event_id=' . $event_id);


                if ($assignedTo) {
                    $event_users = array();
                    foreach ($assignedTo as $user) {
	                    if ($user) {
                        	$event_users[] = array('event_id' => $event_id, 'staff_id' => $user);
                        }
                    }
                    if ($event_users) {
                        $this->db->insert_batch('booking_event_users', $event_users);
                    }
                }

                if ($booking_id) {
                    // get guest id
                    $query = $this->db->get_where('bookings', 'booking_id='.$booking_id);
                    $booking_data = $query->row_array();

                    $item_data = $this->item->get($item_id);
                    $message = $item_data['title'] . ' were changed.';
                    $this->db->insert('messages', array(
                        'message' => $message,
                        'receiver' => $booking_data['guest_id'],
                        'date_sent' => date('c', now()),
                        'sender' => get_current_user_id(),
                    ));

                    $guest_data = get_user($booking_data['guest_id']);
                    $current_user = get_current_user_data();

                    if ($guest_data['email']) {

                        $sdate = new DateTime($data['start_dt']);
                        $edate = new DateTime($data['end_dt']);

                        $body = 'Date : ' . $sdate->format('m/d/Y') . "\n" .
                            'Time : ' . $sdate->format('g:iA') . ' - ' . $edate->format('g:iA') . "\n" .
                            'Treatment : ' . $item_data['title'] . "\n" .
                            'Price : P' . $item_data['amount'] . "\n" .
                            'Duration : ' . $item_data['duration'] . ' minutes'."\n".
                            'Status : '.ucwords($data['status']);

                        $headers = 'From: ' . $current_user['email'] . '<' . $current_user['first_name'] . ' ' . $current_user['last_name'] . ">\r\n" . 'CC: immarvin@gmail.com, jay_cruz@thefarm.com.ph' . "\r\n";

                        mail($guest_data['email'], $message, $body, $headers);
                    }

                }

            } else {
                $data['author_id'] = get_current_user_id();
                $data['entry_date'] = now();
                $this->db->insert('booking_events', $data);
                $event_id = $this->db->insert_id();
                $item_data = $this->item->get($item_id);

                if ($event_id && $assignedTo = $this->input->get_post('assigned_to')) {

                    if ($assignedTo) {
                        $event_users = array();
                        foreach ($assignedTo as $user) {
                            $event_users[] = array('event_id' => $event_id, 'staff_id' => $user);
                        }
                        $this->db->delete('booking_event_users', 'event_id=' . $event_id);
                        $this->db->insert_batch('booking_event_users', $event_users);
                    }

                    $current_user = get_current_user_data();

                    //build message.
                    $message = $current_user['first_name'] . ' ' . $current_user['last_name'] . ' assigned you to <a href="#"> "';
                    if ($item_data) {
                        $message .= $item_data['title'] . ' ';
                    }
                    if ($data['event_title']) {
                        $message .= $data['event_title'] . ' ';
                    }

                    $message .= '"</a> on ' . date('m/d/Y', strtotime($data['start_dt']));

                    $message .= '.';

                    if ($assignedTo) {
                        foreach ($assignedTo as $user) {
                            $this->db->insert('messages', array(
                                'message' => $message,
                                'receiver' => $user,
                                'date_sent' => date('c', now()),
                                'sender' => get_current_user_id(),
                            ));
                        }
                    }
                }

                if ($booking_id) {
                    // get guest id
                    $query = $this->db->get_where('bookings', 'booking_id='.$booking_id);
                    $booking_data = $query->row_array();

                    $message = $item_data['title'] . ' were added to your treatments.';
                    $this->db->insert('messages', array(
                        'message' => $message,
                        'receiver' => $booking_data['guest_id'],
                        'date_sent' => date('c', now()),
                        'sender' => get_current_user_id(),
                    ));

                    $guest_data = get_user($booking_data['guest_id']);
                    $current_user = get_current_user_data();

                    if ($guest_data['email']) {

                        $sdate = new DateTime($data['start_dt']);
                        $edate = new DateTime($data['end_dt']);

                        $body = 'Order Slip ' . "\n\n" .
                            'Date : ' . $sdate->format('m/d/Y') . "\n" .
                            'Time : ' . $sdate->format('g:iA') . ' - ' . $edate->format('g:iA') . "\n" .
                            'Treatment : ' . $item_data['title'] . "\n" .
                            'Price : P' . $item_data['amount'] . "\n" .
                            'Duration : ' . $item_data['duration'] . ' minutes';

                        $headers = 'From: ' . $current_user['email'] . '<' . $current_user['first_name'] . ' ' . $current_user['last_name'] . ">\r\n" . 'CC: immarvin@gmail.com, jay_cruz@thefarm.com.ph' . "\r\n";

                        mail($guest_data['email'], $message, $body, $headers);
                    }
                }
            }


            if ($this->input->is_ajax_request()) {
                $event = get_event($event_id);

                if ($event) {

                    $event['start'] = date('c', strtotime($event['start']));
                    $event['end'] = date('c', strtotime($event['end']));
                    $this->output->set_content_type('application/json');

                    echo json_encode($event);
                    die();
                }
            }
        }

        $locations = array();
        foreach (get_locations() as $location_id => $location_name) {
            if (current_user_can('can_view_schedules_' . $location_id)) {
                $locations[(int)$location_id] = $location_name;
            }
        }

        $styles = get_statuses_style(2);
        $inline_css = array();
        foreach ($styles as $status => $style) {
            $inline_css[] = array(
                'name' => array(
                    '.fc-event-status-' . url_title($status, 'underscore'),
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-bg',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content .fc-time',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content .fc-title'),
                'style' => $style);
        }

        $inline_css[] = array('name' => array(
            '.fc-event-included',
            '.fc-event-included .fc-bg',
            '.fc-event-included .fc-content',
            '.fc-event-included .fc-content .fc-time',
            '.fc-event-included .fc-content .fc-title'
        ), 'style' => 'background-color: #FFFF00 !important; color: #000; color:#788288 !important;');

        $inline_css[] = array('name' => array(
            '.fc-event-upsell',
            '.fc-event-upsell .fc-bg',
            '.fc-event-upsell .fc-content',
            '.fc-event-upsell .fc-content .fc-time',
            '.fc-event-upsell .fc-content .fc-title'
        ), 'style' => 'background-color: #E6E6FA !important; color: #000;');

        $inline_css[] = array('name' => array(
            '.fc-event-foc',
            '.fc-event-foc .fc-bg',
            '.fc-event-foc .fc-content',
            '.fc-event-foc .fc-content .fc-time',
            '.fc-event-foc .fc-content .fc-title'
        ), 'style' => 'background-color: #FFA500 !important;');

        $inline_css[] = array('name' => array(
            '.fc-event-alacarte',
            '.fc-event-alacarte .fc-bg',
            '.fc-event-alacarte .fc-content',
            '.fc-event-alacarte .fc-content .fc-time',
            '.fc-event-alacarte .fc-content .fc-title'
        ), 'style' => 'background-color: #FFA500 !important;');


        $statuses = get_statuses(2);

        
        $default_view = $this->session->userdata('default_calendar_view');

        $data = array();
        $data['statuses'] = get_statuses(2);
		$data['locations'] = $this->session->userdata('location'); // $locations;
        $data['inline_css'] = $inline_css;
        $inline_js = array(
            'showGuestName' => true,
			'showFacility' => true,
			'abbreviate' => true,
            'resource_field_id' => 'contact_id',
            'businessHours' => false,
            'defaultView' => $default_view ? $default_view : 'byProviders',
            'start_date' => date('Y-m-d'),
            'minTime' => site_pref('start_time'),
            'maxTime' => site_pref('end_time'),
            'booking_id' => 0,
            'droppable' => true,
            'show_providers' => true,
            'header' => array(
                'left' => 'prev, next, today, treatments, nutritionals, print',
                'center' => 'title',
                'right' => $this->session->userdata('calendar_header_right') ? $this->session->userdata('calendar_header_right') : 'agendaDay,agendaWeek,month',
            ),
            'views' => array(
                'byProviders' => array(
                    'type' => 'agendaDay',
                    'duration' => array('days' => 1),
                    'buttonText' => 'providers'),
                'byGuest' => array(
	              	'type' => 'agendaDay',
	              	'duration' => array('days' => 1),
	              	'buttonText' => 'guests'),
                'byProgram' => array(
                    'type' => 'timelineDays',
                    'duration' => array('days' => 1),
                    'buttonText' => 'guests'),
                'byFacilities' => array(
	              	'type' => 'timelineDay',
	              	'duration' => array('days' => 1),
	              	'buttonText' => 'rooms/facilities'),
            ),
            'categories' => array(1, 2, 3, 12),
            'viewFullDetails' => true, //!tf_current_user_can('edit_calendar'),
            'canChange' => current_user_can('can_add_schedule'),
            'statuses' => $statuses,
            'user_id' => $this->session->userdata('user_id'),
            'show_my_appointments' => true,
            
        );
        
        if (current_user_can('can_view_other_schedule')) {
	        $inline_js['show_my_appointments'] = false;
	        $inline_js['locations'] = $locations;
            $inline_js['print_url'] = site_url('backend/calendar/print_schedule');
			$inline_js['show_no_schedule'] = $this->session->userdata('calendar_show_no_schedule');
            $inline_js['selected_locations'] = $this->session->userdata('location_id'); //$this->session->userdata('calendar_view_locations') ? $this->session->userdata('calendar_view_locations') : array();
            $inline_js['selected_statuses'] = $this->session->userdata('calendar_view_status') ? $this->session->userdata('calendar_view_status') : array();
        }
        
        $data['inline_js'] = $inline_js;

        $this->load->view('admin/calendar/index', $data);
    }
    
    public function get_resources_guest_id() {
	    
	    $date = $_REQUEST['date'];
	    
	    $this->db->select('contacts.first_name, contacts.last_name, contacts.contact_id, bookings.booking_id');
	    $this->db->from('bookings');
	    //$this->db->join('packages', 'packages.package_id = bookings.package_id');
	    //$this->db->join('package_types', 'packages.package_type_id = package_types.package_type_id');
	    $this->db->join('contacts', 'bookings.guest_id = contacts.contact_id');
	    $this->db->where('\''.$date.'\' BETWEEN FROM_UNIXTIME(tf_bookings.start_date) AND FROM_UNIXTIME(tf_bookings.end_date)');
        $this->db->where('contacts.deleted', 0);
	    $query = $this->db->get();
	    $results = $query->result_array();

        $resources = array();
	    foreach ($results as $row) {
            $info = array(
            	'id' => $row['contact_id'], 
            	'title' => $row['first_name'] . ' ' . $row['last_name'],
            	'booking_id' => $row['booking_id'],
            );

            $resources[] = $info;
	    }

        $this->output->set_content_type('application/json')->set_output(json_encode($resources));	    
    }
    public function get_resources_by_program() {

        $date = $_REQUEST['date'];

        $this->db->select('package_types.*, contacts.first_name, contacts.last_name, contacts.contact_id, bookings.booking_id');
        $this->db->from('bookings');
        $this->db->join('packages', 'packages.package_id = bookings.package_id');
        $this->db->join('package_types', 'packages.package_type_id = package_types.package_type_id');
        $this->db->join('contacts', 'bookings.guest_id = contacts.contact_id');
        $this->db->where('\''.$date.'\' BETWEEN DATE_FORMAT(FROM_UNIXTIME(tf_bookings.start_date), \'%Y-%m-%d\') AND DATE_FORMAT(FROM_UNIXTIME(tf_bookings.end_date), \'%Y-%m-%d\')');
        //$this->db->where_not_in('bookings.status', array('completed'));
        $query = $this->db->get();
        $results = $query->result_array();

        $guests = array();
        foreach ($results as $row) {
            $info = array(
                'id' => $row['contact_id'],
                'title' => $row['first_name'] . ' ' . $row['last_name'],
                'booking_id' => $row['booking_id'],
            );

            $guests[$row['package_type_id']][] = $info;
        }

        $resources = array();
        foreach ($results as $row) {
            $info = array(
                'id' => 'package_id_'.$row['package_type_id'],
                'title' => $row['package_type_name'],
                'children' => isset($guests[$row['package_type_id']]) ? $guests[$row['package_type_id']] : array()
            );

            $resources[] = $info;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($resources));
    }
    public function get_resources_facility_id()
    {
        $this->db->select('*');
        $this->db->from('facilities');
        $this->db->where_in('facilities.location_id', array(0, $this->session->userdata('location_id')));
        $this->db->order_by('facility_name', 'asc');
        $query = $this->db->get();

        $facilities = $query->result_array();
        $resources = array();
        foreach ($facilities as $row) {

            $info = array('id' => (int)$row['facility_id'], 'title' => $row['facility_name']);
            $resources[] = $info;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($resources));
    }

    public function by_facilities()
    {
        $resources = array();
        $facilities = $this->facility->all();
        foreach ($facilities as $row) {

            $info = array('id' => (int)$row['facility_id'], 'title' => $row['facility_name']);
            $resources[] = $info;
        }

        $styles = get_statuses_style(2);
        $inline_css = array();
        foreach ($styles as $status => $style) {
            $inline_css[] = array(
                'name' => array(
                    '.fc-event-status-' . url_title($status, 'underscore'),
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-bg',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content .fc-time',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content .fc-title'),
                'style' => $style);
        }

        $inline_css[] = array('name' => array(
            '.fc-event-included',
            '.fc-event-included .fc-bg',
            '.fc-event-included .fc-content',
            '.fc-event-included .fc-content .fc-time',
            '.fc-event-included .fc-content .fc-title'
        ), 'style' => 'background-color: #FFFF00 !important;');

        $inline_css[] = array('name' => array(
            '.fc-event-upsell',
            '.fc-event-upsell .fc-bg',
            '.fc-event-upsell .fc-content',
            '.fc-event-upsell .fc-content .fc-time',
            '.fc-event-upsell .fc-content .fc-title'
        ), 'style' => 'background-color: #E6E6FA !important;');

        $inline_css[] = array('name' => array(
            '.fc-event-foc',
            '.fc-event-foc .fc-bg',
            '.fc-event-foc .fc-content',
            '.fc-event-foc .fc-content .fc-time',
            '.fc-event-foc .fc-content .fc-title'
        ), 'style' => 'background-color: #FFA500 !important;');

        $inline_css[] = array('name' => array(
            '.fc-event-alacarte',
            '.fc-event-alacarte .fc-bg',
            '.fc-event-alacarte .fc-content',
            '.fc-event-alacarte .fc-content .fc-time',
            '.fc-event-alacarte .fc-content .fc-title'
        ), 'style' => 'background-color: #FFA500 !important;');


        $data = array();
        $data['statuses'] = get_statuses(2);
        $data['inline_css'] = $inline_css;
        $data['inline_js'] = array(
            'resources' => $resources,
            'view' => 'agendaDay',
            'show_providers' => true,
            'editable' => false,
            'resource_field_id' => 'facility_id',
            'businessHours' => false,
            'defaultView' => 'timelineDay',
            'start_date' => date('Y-m-d'),
            'minTime' => site_pref('start_time'),
            'maxTime' => site_pref('end_time'),
            'showGuestName' => true,
			'showFacility' => false,
			'abbreviate' => true,
            'droppable' => true,
            'header' => array(
                'left' => 'prev, next, today, service_providers',
                'center' => 'title',
                'right' => '',
            ),
            'show_off_providers' => false,
            'viewFullDetails' => true, //!tf_current_user_can('edit_calendar'),
            'canChange' => true,
            'statuses' => get_statuses(2),
            'selected_statuses' => $this->session->userdata('calendar_view_status') ? $this->session->userdata('calendar_view_status') : array(),
            'selected_positions' => $this->session->userdata('calendar_view_positions') ? $this->session->userdata('calendar_view_positions') : array(),
        );

        $this->load->view('admin/calendar/by_facilities', $data);
    }
    
    

    public function get_available_peoples()
    {		
	    $start = !isset($_REQUEST['start_time']) ? date('Y-m-d H:g:s') : $_REQUEST['start_time'];
        $end = !isset($_REQUEST['end_time']) ? date('Y-m-d H:g:s') : $_REQUEST['end_time'];
        $event_id = isset($_REQUEST['event_id']) ? (int)$_REQUEST['event_id'] : 0;
        $status = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : 0;
		$item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : 0;
		
		$params = array(
			'start_date' => $start,
			'end_date' => $end,
			'item_id' => $item_id
		);
		
		$this->load->library('ProviderAvailability', $params);
		
		$this->output->set_content_type('application/json')->set_output(json_encode($this->provideravailability->get_available()));
    }

    public function get_available_providers()
    {
        $start = !isset($_REQUEST['start_time']) ? time() : strtotime($_REQUEST['start_time']);
        $end = !isset($_REQUEST['end_time']) ? time() : strtotime($_REQUEST['end_time']);
        $event_id = isset($_REQUEST['event_id']) ? (int)$_REQUEST['event_id'] : 0;
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 'completed';

        $params = array();
        $params['start'] = date('Y-m-d H:i:s', $start);
        $params['end'] = date('Y-m-d H:i:s', $end);
        $params['event'] = $event_id;
        $params['status'] = $status;
        $params['item_id'] = $_REQUEST['item_id'];
        $params['booking_id'] = $_REQUEST['booking_id'];
        $params['exclude_status'] = array('cancelled', 'completed', 'no-show');// array('cancelled', 'tentative', 'completed');

        $this->load->library('availability', $params);
        $this->availability->validate();

        $resources = array();
        foreach ($this->availability->get_available_peoples() as $people) {
            $resources[] = array(
                'id' => $people['contact_id'],
                'title' => $people['nickname'] ? $people['nickname'] : $people['first_name']);
        }


        $this->output->set_content_type('application/json')->set_output(json_encode($resources));
    }

    public function get_available_facilities()
    {

        $params = array();
        $params['start'] = date('Y-m-d H:i:s', strtotime($_REQUEST['start_time']));
        $params['end'] = date('Y-m-d H:i:s', strtotime($_REQUEST['end_time']));
        $params['event'] = (int)$_REQUEST['event_id'];
        $params['status'] = $_REQUEST['status'];
        $params['item_id'] = $_REQUEST['item_id'];
        //$params['exclude_status'] = array('cancelled', 'completed', 'no-show');

        $this->load->library('availability', $params);
        $this->output
            ->set_content_type('application/json')->set_output(json_encode($this->availability->get_available_facilities()));
    }

    public function get_available_services()
    {
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(available_booking_items($_REQUEST['booking_id'])));
    }
    
    public function get_booking_dates() {
	    $booking_id = (int)$this->input->get_post('booking_id');
        $start_date = strtotime($this->input->get_post('start_date'));
        $end_date = strtotime($this->input->get_post('end_date'));

        if ($booking_id) {
            $query = $this->db->get_where('bookings', 'booking_id=' . $booking_id);
            $result = $query->row_array();

            $start_date = $result['start_date'];
            $end_date = $result['end_date'];
        }
        else {

        }

        $start_date = date('Y-m-d', $start_date);
        $end_date = date('Y-m-d', $end_date);

        $date_range = createDateRangeArray($start_date, $end_date);

        $dates = array();
		foreach ($date_range as $date) $dates[$date] = date('m/d/Y', strtotime($date));
		
		$this->output->set_content_type('application/json')
            ->set_output(json_encode($dates));
    }
    
    public function get_resources_contact_id()
    {
        $resources = array();

        $positions = isset($_REQUEST['positions']) ? $_REQUEST['positions'] : array();
        if (in_array('Others', $positions)) {
            $positions[] = '';
        }

        $include = array();

        if (isset($_REQUEST['show_my_appointments']) && $_REQUEST['show_my_appointments'] === 'true') {
            $include[] = $this->session->userdata('user_id');
            $positions = array();
        }

        $show_no_schedule = false;
        if (isset($_REQUEST['show_no_schedule']) && $_REQUEST['show_no_schedule'] === 'true') {
            $show_no_schedule = true;
        }

        $locations = isset($_REQUEST['locations']) ? $_REQUEST['locations'] : array();

        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Y-m-d');
        $contacts = get_available_providers($date, $locations);
        
        //$contacts = get_provider_list(false, $include, $positions, $locations);
        $codes = get_schedule_codes();
        $positions = array();
        foreach ($contacts as $contact) {
            $position = $contact['position'];
            if ($position === '') $position = 'Others';

            $work_plan = $contact['work_code'];

            if ($work_plan === 'custom') {
                $work_plan = get_provider_day_schedule($contact['contact_id'], $date);
            }
            else {
                $work_plan = $codes[$work_plan];
            }
            
            $info = array('id' => (int)$contact['contact_id'],
                'title' => $contact['first_name'] . "\n" . $work_plan,
                'position' => $position, 
                'hidden' => true,
                'eventClassName' => 'contact-id-' . $contact['contact_id']);
            $resources[] = $info;
            if (!isset($positions[$position])) $contact['position'] = array();
            $positions[$position][] = $info;

        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode($resources));
    }

    public function update_views()
    {

        $statuses = $this->input->get_post('selected_statuses');
        $positions = $this->input->get_post('selected_positions');
        $locations = $this->input->get_post('selected_locations');
        $show_no_schedule = $this->input->get_post('show_no_schedule') === 'true' ? 'y' : 'n';
        $show_my_appointments = $this->input->get_post('show_my_appointments') === 'true' ? 'y' : 'n';

        $this->session->set_userdata('calendar_show_no_schedule', $show_no_schedule === 'y');
        $this->session->set_userdata('calendar_show_my_schedule_only', $show_my_appointments === 'y');
        $this->session->set_userdata('calendar_view_status', $statuses ? $statuses : array());
        $this->session->set_userdata('calendar_view_positions', $positions ? $positions : array());
        $this->session->set_userdata('calendar_view_locations', $locations ? $locations : array());

        $_statuses = '';
        if (is_array($statuses)) {
            $_statuses = implode(',', $statuses);
        }

        $_positions = '';
        if (is_array($positions)) {
            $_positions = implode(',', $positions);
        }

        $_locations = '';
        if (is_array($locations)) {
            $_locations = implode(',', $locations);
        }

        $this->db->update('users', array(
            'calendar_show_no_schedule' => $show_no_schedule,
            'calendar_show_my_schedule_only' => $show_my_appointments,
            'calendar_view_status' => $_statuses,
            'calendar_view_locations' => $_locations,
            'calendar_view_positions' => $_positions),
            'contact_id=' . get_current_user_id());
    }


    public function json()
    {

        $booking_id = $this->uri->segment(4);
        $start = date('Y-m-d', strtotime($this->input->get_post('start')));
        $end = date('Y-m-d', strtotime($this->input->get_post('end')));
        $resource_field_id = $this->input->get_post('resource_field_id');
        $statuses = isset($_REQUEST['status']) ? $_REQUEST['status'] : array();
        $locations = isset($_REQUEST['location']) ? $_REQUEST['location'] : array();
        $show_guest_name = $this->input->get_post('show_guest_name') === 'true';
		$show_facility = $this->input->get_post('show_facility') === 'true';
		$abbreviate = $this->input->get_post('abbreviate') === 'true';
		$guest_id = $this->input->get_post('guest_id');
		$categories = $this->input->get_post('categories');
		$show_my_appointments = $this->input->get_post('show_my_appointments') === 'true';
		
		//get all locations.
		$locations = array();
		foreach ($this->session->userdata('location') as $row) {
			if (current_user_can('can_view_schedules_'.$row)) {		
				$locations[] = $row;
			}
		}
		
		if (!$categories) {
			$categories = array(1, 2, 3);
		}
	
	
		if ($this->session->userdata('group_id') === '5') {
            //get the recent booking_id
            $this->db->select('bookings.booking_id');
            $this->db->from('bookings');
            $this->db->where('bookings.guest_id = ', $this->session->userdata('user_id'));
            $this->db->where('bookings.status', 'confirmed');
            $this->db->limit(1);
            $result = $this->db->get()->row_array();
            $booking_id = $result['booking_id'];
        }
        
        $params = array();
		$params['booking_id'] = $booking_id;
		$params['resource_fld_name'] = $resource_field_id;
		$params['start'] = $start;
		$params['end'] = $end;
		$params['event_status'] = $statuses;
		$params['locations'] = $locations;
		$params['show_guest_name'] = $show_guest_name;
		$params['show_facility_name'] = $show_facility;
		$params['abbreviate'] = $abbreviate;
		$params['guest_id'] = $guest_id;
		$params['categories'] = $categories;
		
		if ($show_my_appointments) $params['provider_id'] = $this->session->userdata('user_id');
		
        $this->load->library('Eventsbuilder', $params);
		
		$this->eventsbuilder->build();
        $this->output->set_content_type('application/json')->set_output(json_encode($this->eventsbuilder->get_events()));
    }

    public function print_schedule()
    {

        $booking_id = $this->uri->segment(4);
        $start = $this->uri->segment(5);
        $locations = $this->session->userdata('calendar_view_locations');
        $positions = $this->session->userdata('calendar_view_positions');
        if ($this->session->userdata('group_id') === '5') {
            //get the recent booking_id
            $this->db->select('bookings.booking_id');
            $this->db->from('bookings');
            $this->db->where('bookings.guest_id = ', $this->session->userdata('user_id'));
            $this->db->where('bookings.status', 'confirmed');
            $this->db->limit(1);
            $result = $this->db->get()->row_array();
            $booking_id = $result['booking_id'];
        }

        $resources = array();
        $include = array();
        $statuses = array();

        $contacts = get_provider_list(false, $include, $positions, $locations);

        $events = get_events($booking_id, 0, 'contact_id', $start, $start, false, 'confirmed', $statuses, $locations);

        $styles = get_statuses_style(2);
        $inline_css = array();
        foreach ($styles as $status => $style) {
            $inline_css[] = array(
                'name' => array(
                    '.fc-event-status-' . url_title($status, 'underscore'),
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-bg',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content .fc-time',
                    '.fc-event-status-' . url_title($status, 'underscore') . ' .fc-content .fc-title'),
                'style' => $style);
        }

        $inline_css[] = array('name' => array(
            '.fc-event-included',
            '.fc-event-included .fc-bg',
            '.fc-event-included .fc-content',
            '.fc-event-included .fc-content .fc-time',
            '.fc-event-included .fc-content .fc-title'
        ), 'style' => 'background-color: #FFFF00 !important;');

        $inline_css[] = array(
            'name' => array('fc-event-foc'),
            'style' => 'background-color: #FFA500;'
        );

        $data['inline_css'] = $inline_css;
        $data['providers'] = $contacts;

        $_events = array();

        $event_count = array();

        foreach ($events as $event) {
            if (isset($event['resourceIds'])) {
                for ($i = strtotime($event['start']); $i < strtotime($event['end']); $i += 1800) {  // 1800 = half hour, 86400 = one day
                    $tm = $i;
                    $dt = date('Y-m-d', $i);
                    $t = sprintf('%1$s', date('H:i', $tm));
                    foreach ($event['resourceIds'] as $r) {
                        $_events[$r][$t] = $event;


                    }

                    if (!isset($event_count[$event['event_id']])) $event_count[$event['event_id']] = 1;
                    else $event_count[$event['event_id']]++;
                }


            }
        }

        $data['date'] = date('F d, Y', strtotime($start));

        $data['provider_events'] = $_events;

        $data['event_count'] = $event_count;

        $this->load->view('admin/calendar/print', $data);
    }
    
    public function unassigned_events() {
	    $params = array();
	    $params['locations'] = $this->session->userdata('location_id');
	    $params['unassigned_only'] = true;
	    $params['categories'] = array(1, 2, 9);
	    $params['upcoming'] = true;
	    $params['upcoming_duration'] = 'P7D';
	    $this->load->library('Eventsbuilder', $params);
	    
	    $this->eventsbuilder->build();
        $this->output->set_content_type('application/json')->set_output(json_encode($this->eventsbuilder->get_events()));
    }

    public function ics()
    {

        $event_id = $this->uri->segment(4);
        $filename = $event_id . '.ics';

        $event = get_event($event_id);

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $summary = $event['provider_name'] . ' - ' . $event['facility_name'];

        $data['summary'] = $summary;
        $data['event'] = $event;

        $this->load->view('ics', $data);
    }

    public function update_inventory()
    {
        $booking_item_id = (int)$this->input->get_post('booking_item_id');
        $qty = (int)$this->input->get_post('qty');

        $this->db->update('booking_items', array('inventory' => $qty), 'booking_item_id=' . $booking_item_id);
    }

    public function delete()
    {
        $event_id = $this->uri->segment(4);

        $this->db->update('booking_events', array(
            'deleted' => 'y',
            'deleted_by' => get_current_user_id(),
            'deleted_date' => now()), 'event_id=' . (int)$event_id);

        $return = $this->input->get_post('return');

        $this->session->set_flashdata('message', 'Appointment successfully deleted.');

        redirect($return);
    }
}
