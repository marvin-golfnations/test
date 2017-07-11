<?php

function get_event($id)
{
    $events = get_events(false, $id);

    if ($events) {
        return $events[0];
    }

    return false;
}

function get_events($booking_id = false, $event_id = false,
                    $resource_fld_name = 'contact_id',
                    $start = '', $end = '', $guest_id = false,
                    $status = 'confirmed', $event_status = false,
                    $locations = array(), $show_guest_name = true,
                    $use_abbr = true, $show_facility_name = true)
{

    $TF = get_instance();

    $TF->db->distinct();
    $TF->db->select('
    booking_items.booking_item_id,
    booking_events.event_id, booking_events.event_title, bookings.booking_id, 
    booking_events.status, facilities.bg_color, 
    booking_events.start_dt AS start, bookings.booking_id,
    booking_events.end_dt AS end, 
    CONCAT(guests.first_name, " ", guests.last_name) as guest_name,
    facilities.facility_name,
    facilities.abbr AS facility_abbr,  
    booking_events.notes, booking_events.booking_item_id, facilities.facility_id,
    items.title as item_name, booking_items.included, items.duration, items.amount as price, items.item_id, items.abbr as item_abbr, categories.location_id, booking_items.upsell, booking_items.foc
    ');
    $TF->db->from('booking_events');
    $TF->db->join('booking_items', 'booking_items.booking_item_id = booking_events.booking_item_id', 'left');
    $TF->db->join('items', 'booking_items.item_id = items.item_id', 'left');
    $TF->db->join('item_categories', 'items.item_id = item_categories.item_id', 'left');
    $TF->db->join('categories', 'item_categories.category_id = categories.cat_id', 'left');
    $TF->db->join('bookings', 'bookings.booking_id = booking_items.booking_id', 'left');
    $TF->db->join('contacts guests', 'bookings.guest_id = guests.contact_id', 'left');
    $TF->db->join('facilities', 'facilities.facility_id = booking_events.facility_id', 'left');


    if ($event_id) {
        $TF->db->where('booking_events.event_id', $event_id);
    } else {

        if ($booking_id) {
            if (!is_array($booking_id)) {
                $booking_id = array($booking_id);
            }

            $TF->db->where_in('bookings.booking_id', $booking_id);


            if ($status) {
                if (!is_array($status)) {
                    $status = array($status);
                }
                $TF->db->where_in('bookings.status', $status);
            }
        }


        if ($guest_id) {
            if (!is_array($guest_id)) {
                $guest_id = array($guest_id);
            }
            $TF->db->where('bookings.guest_id IN (' . implode(', ', $guest_id) . ')');
        }


        if ($start) {
            $TF->db->where("DATE_FORMAT(tf_booking_events.start_dt, '%Y-%m-%d') BETWEEN '{$start}' AND '{$end}'");
        }

        if ($event_status) {
            if (!is_array($event_status)) {
                $event_status = array($event_status);
            }
            $TF->db->where_in('booking_events.status', $event_status);
        }

        if ($locations) {
            $location_ids = array();
            foreach ($locations as $location) {
                if (current_user_can('can_view_schedules_' . $location)) {
                    $location_ids[] = (int)$location;
                }
            }
            if ($location_ids) {
	            $TF->db->where('(categories.location_id IN ('.implode(',', $location_ids).') OR categories.location_id IS NULL)');
//	            $TF->db->where_in('categories.location_id', $location_ids);
//				$TF->db->or_where(array('categories.location_id' => NULL));
			}
        }

        $TF->db->where('booking_events.deleted', 'n');
    }

    $query = $TF->db->get();

    $events = array();
    $results = $query->result_array();
    for ($i = 0; $i < count($results); $i++) {

        $classNames = array();
        $results[$i]['id'] = (int)$results[$i]['event_id'];

        $results[$i]['title'] = $results[$i]['event_title'];
        $results[$i]['editable'] = false;
        $results[$i]['overlap'] = false;

        if ($results[$i]['location_id'] !== null && current_user_can('can_edit_schedules_' . $results[$i]['location_id'])) {
            $results[$i]['editable'] = true;
        }

        if ($results[$i]['item_id'] === null) {
            $results[$i]['editable'] = true;
        }

        if ($results[$i]['included'] === '1') {
            $classNames[] = 'fc-event-included';
        }

        if ($results[$i]['upsell'] === '1') {
            $classNames[] = 'fc-event-upsell';
        }

        if ($results[$i]['foc'] === '1') {
            $classNames[] = 'fc-event-foc';
        }

        $event_users = get_event_users($results[$i]['event_id']);
        $results[$i]['users'] = $event_users;
        if ($resource_fld_name === 'contact_id') {
            $resourceIds = array();
            if ($event_users) {
                foreach ($event_users as $user) {
                    $resourceIds[] = (int)$user['contact_id'];
                }
            }

            $results[$i]['resourceIds'] = $resourceIds;
        } else {
            if (isset($results[$i][$resource_fld_name]))
                $results[$i]['resourceId'] = (int)$results[$i][$resource_fld_name];
        }

        $status = url_title($results[$i]['status'], 'underscore');

        if ($status === 'receptionist') {
            $results[$i]['event_title'] = 'Receptionist';
        }

        $classNames[] = 'fc-event-status-' . $status;

        $titles = array();

        if ($results[$i]['item_abbr'] && $use_abbr) {
            $titles[] = $results[$i]['item_abbr'];
        } elseif ($results[$i]['item_name']) {
            $titles[] = $results[$i]['item_name'];
        }

        if ($show_facility_name) {
            if ($results[$i]['facility_abbr'] && $use_abbr) {
                $titles[] = $results[$i]['facility_abbr'];
            } elseif ($results[$i]['facility_name']) {
                $titles[] = $results[$i]['facility_name'];
            }
        }

        $results[$i]['titles'] = $titles;

        if ($show_guest_name) {
            $title = $results[$i]['guest_name'] . (count($titles) > 0 ? "\n" . implode('/', $titles) : '');
        } else {
            $results[$i]['backgroundColor'] = $results[$i]['bg_color'];
            $title = (count($titles) > 0 ? implode('/', $titles) : '');
        }

        $results[$i]['show_tooltip'] = true;

        if ($title === '') {
            $title = $results[$i]['notes'];
            $results[$i]['show_tooltip'] = false;
        }

        $results[$i]['title'] = $title;

        $results[$i]['className'] = implode(' ', $classNames);

        $events[] = $results[$i];
    }

    return $events;
}

function get_event_item($booking_item_id, $locations = array())
{
    $TF =& get_instance();
    $TF->db->select('*');
    $TF->db->from('booking_items');
    $TF->db->join('items', 'booking_items.item_id = items.item_id');
    $TF->db->join('item_categories', 'items.item_id = item_categories.item_id');
    $TF->db->join('categories', 'item_categories.category_id = categories.cat_id');
    $TF->db->where('booking_items.booking_item_id', (int)$booking_item_id);

    if ($locations) {
        $TF->db->where_in('categories.location_id', $locations);
    }

    $query = $TF->db->get();

    if ($query->num_rows() > 0) {
        return $query->row_array();
    }

    return false;

}

function get_event_users($event_id)
{
    $TF =& get_instance();
    $TF->db->select('contacts.*, users.*');
    $TF->db->from('booking_event_users');
    $TF->db->join('contacts', 'contacts.contact_id = booking_event_users.staff_id');
    $TF->db->join('users', 'contacts.contact_id = users.contact_id');
    $TF->db->where('booking_event_users.event_id', (int)$event_id);

    $query = $TF->db->get();

    if ($query->num_rows() > 0) {
        return $query->result_array();
    }

    return false;

}