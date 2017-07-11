<?php

class Availability
{
    var $room;
    var $people;
    var $start;
    var $start_ts;
    var $end;
    var $end_ts;
    var $event;
    var $status;
    var $exclude_status;
    var $exclude_peoples;
    var $exclude_facilities;
    var $booking_id = false;
    var $item_id;
    var $exclude_categories = array(
        12, // Nutrional Activities
        3,  // Alive
    );
    var $is_frontend = false;
    var $errors;

    var $TF;

    public function __construct($params)
    {
        $this->TF =& get_instance();

        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
        $this->start_ts = new DateTime($this->start);
        $this->end_ts = new DateTime($this->end);
        $this->errors = array();
    }

    private function is_item_no_validate() {
        if (!$this->item_id) return FALSE;

        $q = $this->TF->db->get_where('item_categories', 'item_categories.item_id = '.$this->item_id);

        if ($q->num_rows() === 0) return FALSE;

        if (!is_array($this->exclude_categories)) {
            $this->exclude_categories = array($this->exclude_categories);
        }

        foreach ($q->result_array() as $row) {
            if ($row['category_id']) {
                if (in_array($row['category_id'], $this->exclude_categories)) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    public function validate() {

        if (!$this->start && !$this->end && $this->status != 'confirmed') return TRUE;

        if ($this->exclude_status && in_array($this->status, $this->exclude_status)) return TRUE;

        if ($this->booking_id === 0) return TRUE;

        if ($this->is_item_no_validate())
        {
            return TRUE;
        }

        // check guest.
        $this->TF->db->distinct();
        $this->TF->db->select("booking_events.*, bookings.fax, item_categories.category_id");
        $this->TF->db->from('booking_events');
        $this->TF->db->join('booking_items', 'booking_events.booking_item_id = booking_items.booking_item_id');

        $this->TF->db->join('items', 'booking_items.item_id = items.item_id');
        $this->TF->db->join('item_categories', 'item_categories.item_id = items.item_id');

        $this->TF->db->join('bookings', 'bookings.booking_id = booking_items.booking_id', 'left');
        $this->TF->db->where_not_in('booking_events.status', array('cancelled', 'no-show'));
        $this->TF->db->where('bookings.booking_id='.$this->booking_id);


        if ($this->exclude_categories) {
            if (!is_array($this->exclude_categories)) {
                $this->exclude_categories = array($this->exclude_categories);
            }
            $this->TF->db->where_not_in('item_categories.category_id', $this->exclude_categories);
        }

        if ($this->event) $this->TF->db->where('booking_events.event_id != ', $this->event);

        $start = new DateTime($this->start);
        $start->add(new DateInterval('PT1M'));

        $end = new DateTime($this->end);
        $end->sub(new DateInterval('PT1M'));

        $check_in = $start->format('Y-m-d H:i:s');
        $check_out = $end->format('Y-m-d H:i:s');

        $this->TF->db->where("((start_dt BETWEEN '$check_in' AND '$check_out') OR (end_dt BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN start_dt AND end_dt))");

        $query = $this->TF->db->get();

//        $this->errors[] = $this->TF->db->last_query();

        if ($query->num_rows() > 0) {
            $guest_schedules = $query->result_array();

            $existing_schedule = count($guest_schedules);
            $fax = (int)$guest_schedules[0]['fax'];

            if ($existing_schedule >= $fax) {
                if ($this->is_frontend) {
                    $this->errors[] = 'You have an existing appointment on the date and time selected.';
                }
                else {
                    $this->errors[] = 'The guest selected has existing appointment on the date and time selected.';
                }
                return false;
            }
        }

        $query->free_result();
        // get provider working schedule.
        if ($this->people) {
            $user = get_users($this->people);
            if ($user) {
                $user = $user[0];
                $location_id = $user['location_id'];
                if (!$this->TF->session->userdata('can_edit_schedules_'.$location_id)) {
                    $this->errors[] = 'You dont have permissions to assign this provider.';
                    return false;
                }
            }

            $date = date('Y-m-d', strtotime($this->start));
            $providers = get_available_providers($date, $this->people);

            //$providers = get_provider_list(false, $this->people);

            if ($providers) {

                foreach ($providers as $row) {

//                    $work_plan = unserialize($row['work_plan']);
//                    $first_name = $row['first_name'];
//                    if ($work_plan) {
//                        $start_week_l = date('l', strtotime($this->start));
//                        $date = date('Y-m-d', strtotime($this->start));
//
//                        if (isset($work_plan[$date]) && !is_array($work_plan[$date])) {
//                            $this->exclude_peoples[] = (int)$row['contact_id'];
//                            $this->errors[] = sprintf('%s is on %s on the date selected.', $first_name, $work_plan[$date]);
//                        } elseif (isset($work_plan[$date])) {
//                            //sort time
//                            $w = $work_plan[$date];
//
//                            sort($w);
//                            $has_working_schedule = false;
//                            foreach ($w as $t) {
//                                $start_ts = new DateTime($date . ' ' . $t);
//                                $end_ts = new DateTime($date . ' ' . $t);
//                                $end_ts->add(new DateInterval('PT59M'));
//                                if ($start_ts <= $this->start_ts && $end_ts >= $this->start_ts) {
//                                    $has_working_schedule = true;
//                                    break;
//                                }
//                            }
//
//                            if ($has_working_schedule === false) {
//                                $this->exclude_peoples[] = (int)$row['contact_id'];
//                                $this->errors[] = sprintf('%s has no working schedule on the date and time selected. <br />%s: <br/>%s', $first_name, $start_week_l, implode('<br />', $w));
//                            }
//                        }
//                    }


                    $this->TF->db->select('*');
                    $this->TF->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id');
                    $this->TF->db->where_in('booking_event_users.staff_id', $this->people);
                    //$this->TF->db->where_not_in('status', array('cancelled', 'no-show'));
                    if ($this->event) $this->TF->db->where('booking_events.event_id !=', $this->event);
                    $this->TF->db->where("((start_dt BETWEEN '$check_in' AND '$check_out') OR (end_dt BETWEEN '$check_in' AND '$check_out') OR ('$check_in' BETWEEN start_dt AND end_dt))");
                    $query = $this->TF->db->get('booking_events');

                    if ($query->num_rows() > 0) {
                        $event = $query->row_array();
                        $this->exclude_peoples[] = (int)$row['contact_id'];
                        $event_info = get_event($event['event_id']);
                        $reason = sprintf('Guest : <b>%s</b><br />Start : <b>%s</b><br />End : <b>%s</b>', $event_info['guest_name'], $event_info['start'], $event_info['end']);
                        $this->errors[] = sprintf('%s is not available at booking time.<br />%s', $row['first_name'], $reason);
                    }
                    $query->free_result();
                }
            }
        }

//		$this->errors[] = $this->TF->db->last_query();

        if ($this->room) {

            $this->TF->db->distinct();
            $this->TF->db->select("facilities.facility_name, booking_events.facility_id, facilities.max_accomodation");
            $this->TF->db->from('booking_events');
            $this->TF->db->join('booking_items', 'booking_events.booking_item_id = booking_items.booking_item_id');
            $this->TF->db->join('facilities', 'facilities.facility_id = booking_events.facility_id', 'left');
            $this->TF->db->join('bookings', 'bookings.booking_id = booking_items.booking_id', 'left');
            $this->TF->db->where('booking_events.status', 'confirmed');
            $this->TF->db->where('facilities.status', 1);
            $this->TF->db->where('booking_events.facility_id', $this->room);


            if ($this->event) $this->TF->db->where('booking_events.event_id != ', $this->event);
            $this->TF->db->where("'{$this->start}' <= DATE_SUB(end_dt, INTERVAL 1 MINUTE) AND '{$this->end}' >= start_dt");
            $query = $this->TF->db->get();

            if ($query->num_rows() > 0) {

                foreach ($query->result_array() as $row) {

                    $max_accomodation = intval($row['max_accomodation']);
                    $facility_name = $row['facility_name'];

                    $this->TF->db->select("COUNT(*) as existing_accomodation");
                    $this->TF->db->from('booking_events');
                    $this->TF->db->join('booking_items', 'booking_events.booking_item_id = booking_items.booking_item_id');
                    $this->TF->db->join('bookings', 'bookings.booking_id = booking_items.booking_id', 'left');
                    $this->TF->db->where_not_in('booking_events.status', array('cancelled', 'no-show'));
                    $this->TF->db->where('booking_events.facility_id', (int)$row['facility_id']);
                    if ($this->event) $this->TF->db->where('booking_events.event_id != ', $this->event);
                    $this->TF->db->where("'{$this->start}' <= DATE_ADD(end_dt, INTERVAL 1 MINUTE) AND '{$this->end}' >= start_dt");
                    $row1 = $this->TF->db->get()->row_array();
                    $existing_accomodation = intval($row1['existing_accomodation']);

                    if ($existing_accomodation >= $max_accomodation) {
                        $this->exclude_facilities[] = (int)$row['facility_id'];
                        $this->errors[] = 'The room you selected is no longer available at booking time.';
                    }
                }
            }
            $query->free_result();
        }
        return count($this->errors) == 0;
    }

    public function get_error_messages() {
        if ($this->errors) {
            return $this->errors;
        }

        return array();
    }

    public function display_errors() {
        if ($this->errors) {
            if ($this->TF->input->is_ajax_request()) {
                $this->TF->output->set_content_type('application/json');
                echo json_encode(array('errors' => $this->errors));
                exit();
            }
            else {

                //build error message;
                $message = '<ul>';
                foreach ($this->errors as $error) {
                    $message .= '<li>'.$error.'</li>';
                }
                $message .= '</ul>';
                show_error($message);
            }
        }
    }

    public function get_available_peoples() {

        $providers = get_available_providers_time($this->start, $this->end);

        if (count($providers) === 0)
            return array();


        $peoples = array();
        //available providers for the day.
        foreach ($providers as $row) {
            $peoples[] = $row['contact_id'];
        }


        $this->TF->db->select('contacts.contact_id, first_name, last_name, nickname, position');
        $this->TF->db->join('users', 'users.contact_id = contacts.contact_id');
        $this->TF->db->join('groups', 'groups.group_id = users.group_id');
        $this->TF->db->join('items_related_users', 'contacts.contact_id = items_related_users.contact_id');
        if ($this->exclude_peoples) {
            $this->TF->db->where_not_in('contacts.contact_id', $this->exclude_peoples);
        }

        if ($this->TF->session->userdata('location_id') !== 0) {
            $this->TF->db->where('users.location_id IN (0, '.$this->TF->session->userdata('location_id').')');
        }

        $this->TF->db->where_in('contacts.contact_id', $peoples);

        if ($this->item_id) {
            $this->TF->db->where('items_related_users.item_id', $this->item_id);
        }

        $this->TF->db->where('groups.include_in_provider_list = "y"');
        $this->TF->db->order_by('users.order', 'asc');
        $query = $this->TF->db->get('contacts');
        $data = $query->result_array();
        $query->free_result();
        return $data;
    }

    public function get_available_facilities() {

        $this->TF->db->distinct();
        $this->TF->db->select('facilities.*');
        $this->TF->db->from('facilities');
        $this->TF->db->join('items_related_facilities', 'items_related_facilities.facility_id = facilities.facility_id');
        if ($this->exclude_facilities) {
            $this->TF->db->where('facility_id NOT IN ('.implode(', ', $this->exclude_facilities).')');
        }

        if ($this->TF->session->userdata('location')) {

            $locations = $this->TF->session->userdata('location');

            $locations[] = 0;

            $this->TF->db->where_in('facilities.location_id', $locations);
        }

        if ($this->item_id)
            $this->TF->db->where('items_related_facilities.item_id', $this->item_id);

        $this->TF->db->where('facilities.status', 1);
        $this->TF->db->order_by('facility_name', 'asc');
        $query = $this->TF->db->get();
        $data = $query->result_array();
        $query->free_result();
        return $data;
    }
}