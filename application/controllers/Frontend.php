<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends TF_Controller
{

    private function get_booking()
    {
        $query = $this->db->get_where('bookings', 'guest_id = ' . (int)get_current_user_id() . ' AND status = "confirmed"');
        $booking = $query->row_array();

        return $booking;
    }

    private function get_activities($date)
    {

        $start = date('Y-m-d 00:00:00', $date);
        $end = date("Y-m-d 23:59:59", $date);

        $this->db->distinct();
        $this->db->select('booking_events.*, items.description, facilities.bg_color, items.title as item_name, items.duration, facilities.facility_name, contacts.first_name, contacts.last_name, contacts.nickname');
        $this->db->from('booking_events');
        $this->db->join('items', 'items.item_id = booking_events.item_id', 'left');
        $this->db->join('item_categories', 'items.item_id = item_categories.item_id', 'left');
        $this->db->join('facilities', 'facilities.facility_id = booking_events.facility_id', 'left');
        $this->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id', 'left');
        $this->db->join('contacts', 'contacts.contact_id = booking_event_users.staff_id', 'left');
        $this->db->where_in('item_categories.category_id', array(4, 9, 10));
        $this->db->where('booking_events.deleted', 'n');
        $this->db->where("booking_events.start_dt BETWEEN '{$start}' AND '{$end}'");

        $this->db->order_by('booking_events.start_dt', 'asc');

        $results = $this->db->get();

        if ($results->num_rows() === 0) {
            return array();
        }

        return $results->result_array();


    }

    public function index()
    {

        //get existing booking
        $booking = $this->get_booking();
        $data['return'] = '';
        $data['contact_id'] = $this->session->userdata('user_id');

        $activities = $this->get_activities(time());

//        $next_day = date('Y-m-d', time());
//        $next_day = date('Y-m-d', strtotime('+1 day', strtotime($next_day)));
//        $next_day = strtotime($next_day . ' 06:00:00');

        $data['activities'] = $activities; //!$activities ? $this->get_activities($next_day) : $activities;

        $upcoming_treatments = null;
        $upcoming_activities = null;

        if ($booking !== null) {
            $params = array();
            $params['booking_id'] = $booking['booking_id'];
            $params['categories'] = array(1, 2);
            $params['start'] = date('Y-m-d 00:00:00');
            $params['end'] = date('Y-m-d 23:59:59');

            $this->load->library('Eventsbuilder', $params, 'upcoming_treatments');
            $this->upcoming_treatments->build();
            $upcoming_treatments = $this->upcoming_treatments->get_events();


            $params = array();
            $params['booking_id'] = $booking['booking_id'];
            $params['categories'] = array(12);
            $params['start'] = date('Y-m-d 00:00:00');
            $params['end'] = date('Y-m-d 23:59:59');
            $this->load->library('Eventsbuilder', $params, 'upcoming_activities');
            $this->upcoming_activities->build();
            $upcoming_activities = $this->upcoming_activities->get_events();
        }


        $data['inline_js'] = array(
            'booking_id' => $booking['booking_id'],
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
                'left' => 'prev, next',
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

        $this->db->where_in("location_id", array(1, 2, 3));
        $query = $this->db->get("categories");

        $data['categories'] = $query->result_array();
        $data['upcoming_treatments'] = $upcoming_treatments;
        $data['upcoming_activities'] = $upcoming_activities;

        $this->db->select('contacts.*, bookings.title as program_name, bookings.booking_id, bookings.package_id');
        $this->db->from('contacts');
        $this->db->join('bookings', 'bookings.guest_id = contacts.contact_id');
        //$this->db->where('UNIX_TIMESTAMP() BETWEEN bookings.start_date AND tf_bookings.end_date');
        $query = $this->db->get();
        $guests = $query->result_array();

        $guest_by_packages = array();
        foreach ($guests as $guest) {
            $guest_by_packages[$guest['package_id']][] = $guest;
        }

        $data['guests'] = $guest_by_packages;

        $this->db->distinct();
        $this->db->select('packages.*');
        $this->db->from('packages');
        $this->db->join('bookings', 'bookings.package_id = packages.package_id');
        $this->db->where('bookings.status', 'confirmed');
        $query = $this->db->get();
        $packages = $query->result_array();
        $data['default_package'] = $packages ? (int)$packages[0]['package_id'] : 0;
        $data['packages'] = $packages;

        if (isset($params['booking_id']))
            $data['booking_id'] = $params['booking_id'];

        $this->load->view('index', $data);
    }

    function profile()
    {

        $q = $this->db->get_where('contacts', array('contact_id' => $this->session->userdata('user_id')));

        $row = $q->row_array();

        $data['account'] = $row;

        $data['inline_js'] = array(
            'avatar' => $row['avatar'],
        );

        $this->load->view('main/profile', $data);
    }

    function activate()
    {
        $contact_id = $this->session->userdata('user_id');
        $return = $this->input->get_post('return');
        $code = $_REQUEST['activation_code'];

        if ($code) {
            $q = $this->db->get_where('contacts', array('contact_id' => $contact_id, 'activation_code' => $code));
            if ($q->num_rows() > 0) {

                $this->db->update('contacts', array('active' => 'y'), array('contact_id' => $contact_id, 'activation_code' => $code));
                $this->session->set_flashdata('message', 'Your account has been activated and is ready for use.');
                redirect($return);
            }
        }

        show_error('Invalid activation code');
    }

    function guest()
    {

        $this->db->select('contacts.*, items.title as room_name, bookings.title as program_name, bookings.booking_id, bookings.restrictions, bookings.notes, bookings.start_date, bookings.end_date');
        $this->db->from('contacts');
        $this->db->join('bookings', 'bookings.guest_id = contacts.contact_id');
        $this->db->join('items', 'bookings.room_id = items.item_id', 'left');
        $this->db->where('bookings.booking_id', $this->uri->segment(3));
        //$this->db->where('UNIX_TIMESTAMP() BETWEEN bookings.start_date AND tf_bookings.end_date');
        $query = $this->db->get();
        $data['account'] = $query->row_array();
        $data['contact_id'] = $data['account']['contact_id'];
        $data['room_name'] = $data['account']['room_name'];


        $params = array();
        $params['booking_id'] = $this->uri->segment(3);
        $this->load->library('Eventsbuilder', $params);
        $this->eventsbuilder->build();

        $events = array();
        foreach ($this->eventsbuilder->get_events() as $event) {
            $events[date('Y-m-d', strtotime($event['start']))][] = $event;
        }

        $data['events'] = $events;


        $this->load->view('frontend/guest', $data);
    }

    function calculate_time_span($date)
    {

        $seconds = strtotime($date) - strtotime(date('Y-m-d H:i:s'));

        $months = floor($seconds / (3600 * 24 * 30));
        $day = floor($seconds / (3600 * 24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours * 3600)) / 60);
        $secs = floor($seconds % 60);

        if ($seconds < 60)
            $time = $secs . " seconds ago";
        else if ($seconds < 60 * 60)
            $time = $mins . " min ago";
        else if ($seconds < 24 * 60 * 60)
            $time = $hours . " hours ago";
        else if ($seconds < 24 * 60 * 60)
            $time = $day . " day ago";
        else
            $time = $months . " month ago";

        return $time;
    }

    function check_time()
    {
        $date = $this->input->get_post('date');
        $time = $this->input->get_post('time');
        $start_date = $date . ' ' . $time;
        $time_span = $this->calculate_time_span($data['start_dt']);

        if (preg_match('/(\d+) hours ago/i', $time_span, $matches)) {
            $hour_span = (int)$matches[1];
            echo json_encode(array('result' => $hour_span <= 4));
            return;
        }

        echo json_encode(array('result' => false));
        return;
    }

    function service()
    {

        $booking_id = (int)$this->input->get_post('booking_id');
        $item_id = $this->input->get_post('item_id');
        $duration = $this->input->get_post('duration');
        $date = $this->input->get_post('date');
        $time = $this->input->get_post('time');
        $return = $this->input->get_post('return');
        $event_id = $this->input->get_post('event_id');
        $start_date = $date . ' ' . $time;
        $booking_item_id = $this->input->get_post('booking_item_id');

        $query = $this->db->get_where('items', 'item_id=' . $item_id);
        $item = $query->row_array();

        $sdate = new DateTime($start_date);
        $edate = new DateTime($start_date);
        $edate->add(new DateInterval('PT' . $duration . 'M'));

        $data = array(
            'all_day' => 0,
            'status' => 'confirmed',
            'start_dt' => $sdate->format('Y-m-d H:i:s'),
            'end_dt' => $edate->format('Y-m-d H:i:s'),
        );

        if (is_past_date($data['start_dt'])) {
            die('Date is passed.');
        }


        $params = array();
        $params['start'] = $data['start_dt'];
        $params['end'] = $data['end_dt'];
        $params['booking_id'] = $booking_id;
        $params['event'] = $event_id;
        $params['is_frontend'] = true;

        $this->load->library('availability', $params);
        if (!$this->availability->validate()) {
            $this->availability->display_errors();
        }

        $this->db->select('categories.*');
        $this->db->from('item_categories');
        $this->db->join('categories', 'cat_id = category_id');
        $this->db->where('item_id', $item_id);
        $query = $this->db->get();

        $locations = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $locations[] = $row['location_id'];
            }
        }

        if (!$booking_item_id) {
            $this->db->insert('booking_items', array(
                'booking_id' => $booking_id,
                'item_id' => $item_id,
                'quantity' => 1,
                'included' => 0,
            ));

            $booking_item_id = $this->db->insert_id();
        }

        $data['booking_item_id'] = $booking_item_id;

        $data['author_id'] = get_current_user_id();
        $data['entry_date'] = now();

        if (!$booking_item_id) {
            $this->db->insert('booking_events', $data);
        } else {
            $this->db->update('booking_events', $data, array('event_id' => $event_id));
        }

        $this->db->select('contacts.email, contacts.contact_id, contacts.first_name, contacts.last_name, contacts.title, contacts.nickname');
        $this->db->from('contacts');
        $this->db->join('users', 'contacts.contact_id = users.contact_id');
        $this->db->join('groups', 'users.group_id = groups.group_id');
        $this->db->where_in('location_id', $locations);
        $this->db->where('groups.notify_on_bookings', 'y');
        $query = $this->db->get();
        $emails = false;
        if ($query->num_rows() > 0) {

            $emails = array();
            foreach ($query->result_array() as $row) {
                if ($row['email'] !== '') {
                    $emails[$row['contact_id']] = $row['email'];
                }
            }
        }


        if ($emails) {

            $current_user = get_current_user_data();

            //build message.
            $message = $current_user['first_name'] . ' ' . $current_user['last_name'] . ' just made a booking on ' . date('m/d/Y', strtotime($data['start_dt'])) . '.';

            if ($current_user['email'] === '') $current_user['email'] = 'noreply@thefarm.com';


            $ids = array_keys($emails);

            foreach ($ids as $id) {

                $this->db->insert('messages', array(
                    'message' => $message,
                    'receiver' => $id,
                    'date_sent' => date('c', now()),
                    'sender' => get_current_user_id(),
                ));

            }

            $body = 'Order Slip ' . "\n\n" .
                'Date : ' . $sdate->format('m/d/Y') . "\n" .
                'Time : ' . $sdate->format('g:iA') . ' - ' . $edate->format('g:iA') . "\n" .
                'Treatment : ' . $item['title'] . "\n" .
                'Price : P' . $item['amount'] . "\n" .
                'Duration : ' . $item['duration'] . ' minutes';

            $headers = 'From: ' . $current_user['email'] . '<' . $current_user['first_name'] . ' ' . $current_user['last_name'] . ">\r\n" . 'CC: immarvin@gmail.com, jay_cruz@thefarm.com.ph' . "\r\n" . 'BCC: ' . implode(', ', array_values($emails));


            mail('noreply@thefarmatsanbenito.com', $current_user['first_name'] . ' ' . $current_user['last_name'] . ' just made a booking.', $body, $headers);
        }

        $this->session->set_flashdata('message', '<b>' . $item['title'] . '</b> was successfully added to your treatments.');
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


        redirect($return);
    }

    function services()
    {

        $category = $this->uri->segment(1);

        if ($category === 'medical') {
            $category_id = 1;
        } elseif ($category === 'spa') {
            $category_id = 2;
        } elseif ($category === 'cuisine') {
            $category_id = 3;
        } elseif ($category === 'fitness') {
            $category_id = 11;
        } elseif ($category === 'rooms') {
            $category_id = 8;
        }

        //get existing booking
        $this->db->where('guest_id = ' . (int)get_current_user_id() . ' AND status = "confirmed"');
        $this->db->limit(1);
        $query = $this->db->get('bookings');
        $booking = $query->row_array();

        $data['booking_id'] = $booking['booking_id'];

        $data['category_id'] = $category_id;
        $query = $this->db->get_where('categories', 'cat_id=' . $category_id);
        $data['category'] = $query->row_array();

        if ($booking['booking_id'] !== null) {
            $params = array();
            $params['booking_id'] = $booking['booking_id'];
            $params['categories'] = array($category_id);
            $this->load->library('Eventsbuilder', $params, 'treatments');
            $this->treatments->build();
            $data['treatments'] = $this->treatments->get_events();
        }

        $query = $this->db->get_where('categories', 'cat_id=' . $category_id);
        $result = $query->row_array();

        $data['category_id'] = $category_id;
        $data['category_name'] = $result['cat_name'];

        $query = $this->db->get_where('forms', 'form_id = 1');
        $data['form1'] = $query->row_array();

        $this->load->view('main/service', $data);
    }

    // commit test
    function ghq()
    {

        $query = $this->db->get_where('forms', 'form_id = 1');
        $data['form1'] = $query->row_array();

        //get existing booking
        if (is_logged_in()) {
            $query = $this->db->get_where('bookings', 'guest_id = ' . get_current_user_id() . ' AND status = "confirmed"');
            $booking = $query->row_array();

            $data['booking_id'] = $booking['booking_id'];
            $data['inline_js'] = array();

            $query = $this->db->get_where('form_entries_1', 'booking_id=' . (int)$booking['booking_id']);

            $form_data = $query->row_array();

            $data['data'] = $form_data;
            $data['entry_id'] = $form_data['entry_id'];
        }

        $this->load->view('main/ghq', $data);
    }

    function event()
    {

    }

    function calendar()
    {

        $show_resources = false;
        $resource_fld_name = 'contact_id';
        $headerRight = 'byProviders,agendaDay,agendaWeek,month';
        $defaultView = 'byProviders';
        $abbreviate = true;
        $resource_name = 'Packages';
        $headerLeft = 'prev, next, today, filter, print, facilities';
        $editable = true;
        $booking_id = 0;
        $categories = array(1, 2, 3);
        $show_guest_name = true;

        $params = array();

        if ($this->session->userdata('group_id') === 5) {
            //get existing booking
            $query = $this->db->get_where('bookings', 'guest_id = ' . (int)get_current_user_id() . ' AND status = "confirmed"');
            $booking = $query->row_array();
            $headerRight = 'agendaDay, agendaWeek, month';
            $defaultView = 'agendaDay';
            $headerLeft = 'prev,next';
            $abbreviate = false;
            $editable = false;
            $booking_id = $booking['booking_id'];
            $resource_fld_name = '';
            $show_guest_name = false;

        }

        if ($this->session->userdata('group_id') === 11 || $this->session->userdata('group_id') === 13) {
            $defaultView = 'timelineDay';
            $resource_fld_name = 'guest_id';
            $headerRight = 'timelineDay, timelineThreeDays, agendaWeek, month';
            $show_resources = true;
            $resource_name = 'Packages';
            $headerLeft = 'prev,next';
            $editable = false;
            $abbreviate = false;
            $show_guest_name = false;
        }

        $sub_categories = get_categories(1);

        $selected_categories = current($sub_categories);

        $data = array();
        $data['sub_categories'] = $sub_categories;
        $data['inline_js'] = array(
            'showGuestName' => $show_guest_name,
            'showFacility' => true,
            'abbreviate' => $abbreviate,
            'view' => 'agendaDay',
            'editable' => $editable,
            'resource_field_id' => $resource_fld_name,
            'resource_name' => $resource_name,
            'businessHours' => false,
            'defaultView' => $defaultView,
            'start_date' => date('Y-m-d'),
            'minTime' => site_pref('start_time'),
            'maxTime' => site_pref('end_time'),
            'booking_id' => $booking_id,
            'droppable' => true,
            'show_providers' => true,
            'header' => array(
                'left' => $headerLeft,
                'center' => 'title',
                'right' => $headerRight,
            ),
            'categories' => array(1, 2),
            'viewFullDetails' => true, //!tf_current_user_can('edit_calendar'),
            'canChange' => $editable,
            'user_id' => $this->session->userdata('user_id'),
            'guest_id' => $this->session->userdata('user_id'),
            'show_my_appointments' => false, //$this->session->userdata('calendar_show_my_schedule_only'),
            'show_no_schedule' => false, //$this->session->userdata('calendar_show_no_schedule'),
            'selected_locations' => $this->session->userdata('calendar_view_locations') ? $this->session->userdata('calendar_view_locations') : array(),
            'selected_statuses' => $this->session->userdata('calendar_view_status') ? $this->session->userdata('calendar_view_status') : array(),
            'selected_positions' => $this->session->userdata('calendar_view_positions') ? $this->session->userdata('calendar_view_positions') : array(),
        );


        $this->load->view('main/calendar', $data);
    }

    function join_now()
    {

        $start = $this->input->get_post('start');
        $end = $this->input->get_post('end');
        $item_id = $this->input->get_post('item_id');
        $facility_id = $this->input->get_post('facility_id');
        $booking_id = $this->input->get_post('booking_id');

        if (!$booking_id) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => 'You do not have existing booking.')));
            die();
        }

        $params = array();
        $params['room'] = $facility_id;
        $params['start'] = $start;
        $params['end'] = $end;
        $params['booking_id'] = $booking_id;

        $this->load->library('availability', $params);
        if (!$this->availability->validate()) {
            $this->availability->display_errors();
        }

        $data = array(
            'all_day' => 0,
            'status' => 'confirmed',
            'event_title' => '',
            'called_by' => 0,
            'cancelled_by' => 0,
            'cancelled_reason' => '',
            'date_cancelled' => 0,
            'notes' => '',
            'start_dt' => $start,
            'end_dt' => $end,
            'facility_id' => $facility_id,
        );

        $this->db->insert('booking_items', array(
            'booking_id' => $booking_id,
            'item_id' => $item_id,
            'quantity' => 0,
            'included' => 0,
            'foc' => 1,
        ));

        $data['booking_item_id'] = $this->db->insert_id();
        $data['author_id'] = get_current_user_id();
        $data['entry_date'] = now();

        $this->db->insert('booking_events', $data);
        $event_id = $this->db->insert_id();


        $query = $this->db->get_where('items', 'item_id=' . $item_id);
        $item = $query->row_array();

        $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => '<b>' . $item['title'] . '</b> was successfully added to your activities.')));
    }

    function rebook()
    {
        $event_id = (int)$this->uri->segment(3);

        $this->db->select('items.*, booking_events.booking_item_id, booking_events.event_id, booking_events.start_dt, bookings.end_date, bookings.booking_id');
        $this->db->from('booking_events');
        $this->db->join('booking_items', 'booking_events.booking_item_id = booking_items.booking_item_id');
        $this->db->join('bookings', 'bookings.booking_id = booking_items.booking_id');
        $this->db->join('items', 'booking_items.item_id = items.item_id');
        $this->db->where('booking_events.event_id = ' . $event_id);

        $query = $this->db->get();
        $data = $query->row_array();


        $date_range = createDateRangeArray(date('Y-m-d'), date('Y-m-d', $data['end_date']));
        $dates = array('' => '-Selecte Date-');
        foreach ($date_range as $date) $dates[$date] = $date;

        $data['dates'] = $dates;
        $data['times'] = createTimeRangeArray();
        $data['current_date'] = date('Y-m-d', strtotime($data['start_dt']));
        $data['current_time'] = date('H:i:s', strtotime($data['start_dt']));

        $this->load->view('main/rebook', $data);
    }

    function add_service()
    {
        $booking_id = (int)$this->uri->segment(3);
        $item_id = (int)$this->uri->segment(4);
        $category_id = (int)$this->uri->segment(5);

        $query = $this->db->get_where('items', 'item_id=' . (int)$item_id);
        $data = $query->row_array();

        $query = $this->db->get_where('bookings', 'booking_id=' . $booking_id);
        $result = $query->row_array();

        $date_range = createDateRangeArray(date('Y-m-d'), date('Y-m-d', $result['end_date']));
        $dates = array('' => '-Selecte Date-');
        foreach ($date_range as $date) $dates[$date] = $date;

        $data['dates'] = $dates;
        $data['times'] = createTimeRangeArray();
        $data['booking_id'] = $booking_id;
        $data['item_id'] = $item_id;
        $data['category_id'] = $category_id;
        $data['current_date'] = date('Y-m-d');

        $this->load->view('main/add_service', $data);
    }

    function get_available_time()
    {
        $booking_id = (int)$this->input->get_post('booking_id');
        $item_id = (int)$this->input->get_post('item_id');
        $event_id = (int)$this->input->get_post('event_id');
        $duration = (int)$this->input->get_post('duration');
        $duration = $duration === 0 ? 60 : $duration;
        $date = $this->input->get_post('date');

        $available_times = array();

        if ($date === '') {
            $available_times[] = array('' => '-No date selected-');
            return;
        }

        $start_date = new DateTime($date, new DateTimeZone('GMT+8'));
        $end_date = new DateTime($date, new DateTimeZone('GMT+8'));
        $end_date->add(new DateInterval('PT23H'));

        $params = array(
            'item_id' => $item_id,
            'event_id' => $event_id,
            'start_date' => $start_date->format('Y-m-d H:i:s'),
            'end_date' => $end_date->format('Y-m-d H:i:s'));
        $this->load->library('ProviderAvailability', $params);

        $times = $this->provideravailability->get_available_time();

        if (!$times) {
            echo json_encode(array('' => '-Date selected not available-'));
            return;
        }

        $available = array('' => '-Select Time-');
        foreach ($times as $time) {

            //check if provider is available.
            $params = array(
                'start' => $time['start_date'],
                'end' => $time['end_date'],
                'people' => $time['contact_id'],
            );

            $this->load->library('availability', $params);

            $res = $this->availability->validate();
            if ($res) {
                $start_date = new DateTime($time['start_date'], new DateTimeZone('GMT+8'));
                $available[$start_date->format('H:i:s')] = $start_date->format('h:i A');
            }
        }

        echo json_encode($available);
        return;
    }

    function is_available($params, $id)
    {

        $this->load->library('Availability', $params, $id);
        if (!$this->$id->validate()) {
            return false;
        }

        return true;
    }

    function add_to_cart()
    {
        $this->load->library('cart');
        $data = array(
            'id' => $this->input->get_post('item_id'),
            'qty' => 1,
            'price' => $this->input->get_post('price'),
            'name' => $this->input->get_post('name'),
            'options' => array('Size' => 'L', 'Color' => 'Red')
        );
        $this->cart->insert($data);
    }

    function get_cart()
    {
        $this->load->library('cart');

        $output = array('contents' => $this->cart->contents(), 'total' => $this->cart->total(), 'total_items' => $this->cart->total_items());

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    function upload_photo()
    {

        $config = get_upload_config(1);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('avatar')) {
            $file = $this->upload->data();
            $avatar = $config['url'] . '/' . $file['file_name'];
            $contact_id = $this->uri->segment(3);
            $this->db->update('contacts', array('avatar' => $avatar), array('contact_id' => $contact_id));
        } else {
            $this->session->set_flashdata('error_message', $this->upload->display_errors('', ''));
        }
    }
}