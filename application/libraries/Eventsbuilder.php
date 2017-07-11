<?php

class EventsBuilder
{

    var $TF;

    var $booking_id = false;
    var $event_id = false;
    var $resource_fld_name = 'contact_id';
    var $start = '';
    var $end = '';
    var $guest_id = false;
    var $status = 'confirmed';
    var $event_status = false;
    var $locations = array();
    var $show_guest_name = true;
    var $abbreviate = true;
    var $show_facility_name = true;
    var $categories = false;
    var $provider_id = false;

    private $report = false;
    private $report_select = '';
    private $report_group_by = false;

    var $upsell_only = false;
    var $included_only = false;
    var $foc_only = false;

    var $with_guest = true;

    var $order_by = 'start_dt';
    var $group_by = 'event_id';

    var $limit = 1000;

    var $upcoming = false;
    var $upcoming_duration = 'P1D';

    var $guests = array();

    var $unassigned_only = false;

    var $count = 0;

    private $select_columns = array(
        'booking_items.booking_item_id',
        'booking_events.event_id',
        'booking_events.event_title',
        'bookings.booking_id',
        'booking_events.status',
        'facilities.bg_color',
        'booking_events.start_dt AS start',
        'bookings.booking_id',
        'booking_events.end_dt AS end',
        'guests.contact_id AS guest_id',
        'CONCAT(guests.first_name, " ", guests.last_name) as guest_name',
        'facilities.facility_name',
        'facilities.abbr AS facility_abbr',
        'booking_events.notes',
        'booking_events.booking_item_id',
        'facilities.facility_id',
        'items.title as item_name',
        'booking_items.included',
        'items.duration', 'SUM(tf_items.amount) as price',
        'items.item_id',
        'items.abbr as item_abbr',
        'categories.location_id',
        'booking_items.upsell',
        'booking_items.foc',
        'rooms.facility_name as room_name',
        'rooms.abbr as room_abbr',
        'items.description',
        'bookings.package_id',
        'bookings.title as package_name',
        'booking_events.item_id as event_item_id',
        'packages.package_type'
    );

    private $events;

    public function __construct($params = array())
    {
        $this->TF =& get_instance();
        if ($params) {
            foreach ($params as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    private function _build($data, $type = 'daily')
    {
        $included = array();
        $foc = array();
        $upsell = array();
        $output = array();
        $total = 0;

        if ($type === 'monthly') {

            $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

            foreach ($months as $m) {
                $output[$m] = array(
                    'included' => 0,
                    'foc' => 0,
                    'upsell' => 0,
                    'total' => 0,
                    'count' => 0,
                );
            }
        }

        if ($type === 'daily') {
            for ($i = 1; $i <= (int)date('t'); $i++) {
                $output[date('Y-m-' . ($i < 10 ? '0' . $i : $i))] = array(
                    'included' => 0,
                    'foc' => 0,
                    'upsell' => 0,
                    'total' => 0,
                    'count' => 0,
                );
            }
        }

        if ($type === 'weekly') {
            for ($i = 1; $i < (int)date('W'); $i++) {
                $output[$i] = array(
                    'included' => 0,
                    'foc' => 0,
                    'upsell' => 0,
                    'total' => 0,
                    'count' => 0,
                );
            }
        }

        foreach ($data as $row) {

            if ($type === 'daily') {
                $date = date('Y-m-d', strtotime($row['date']));
            } elseif ($type === 'monthly') {
                $date = date('M', strtotime($row['date']));
            } elseif ($type === 'weekly') {
                $date = date('W', strtotime($row['date']));
            } elseif ($type === 'yearly') {
                $date = date('Y', strtotime($row['date']));
            }

            if (!isset($included[$date])) {
                $included[$date] = 0;
            }

            if (!isset($foc[$date])) {
                $foc[$date] = 0;
            }

            if (!isset($upsell[$date])) {
                $upsell[$date] = 0;
            }

            if ($row['included'] === '1' && $row['amount'] !== null) {
                $included[$date] += $row['amount'];
            }

            if ($row['foc'] === '1' && $row['amount'] !== null) {
                $foc[$date] += $row['amount'];
            }

            if ($row['upsell'] === '1' && $row['amount'] !== null) {
                $upsell[$date] += $row['amount'];
            }

            $output[$date] = array(
                'included' => $included[$date],
                'foc' => $foc[$date],
                'upsell' => $upsell[$date],
                'total' => $included[$date] + $upsell[$date]
            );

            $total += $output[$date]['total'];
        }

        //$output['total'] = $total;

        return $output;
    }

    private function _build_monthly_sales($data)
    {
        return $this->_build($data, 'monthly');
    }

    private function _build_weekly_sales($data)
    {
        return $this->_build($data, 'weekly');
    }

    private function _build_daily_sales($data)
    {
        return $this->_build($data, 'daily');
    }

    private function _build_yearly_sales($data)
    {
        return $this->_build($data, 'yearly');
    }

    public function build_sales($params)
    {

        $this->__construct($params);

        $this->report = true;
        $this->report_select = 'DATE_FORMAT(tf_booking_events.start_dt, \'%Y-%m-%d\') as date, 
			booking_items.included, booking_items.foc, booking_items.upsell,
			items.amount, locations.location_id, package_types.package_type_name';
        $query = $this->query();
        $output = array();

        if ($query->num_rows() > 0) {

            $output['daily_sales'] = $this->_build_daily_sales($query->result_array());
            $output['monthly_sales'] = $this->_build_monthly_sales($query->result_array());
            $output['weekly_sales'] = $this->_build_weekly_sales($query->result_array());
            $output['yearly_sales'] = $this->_build_yearly_sales($query->result_array());
        }

        return $output;
    }

    private function query()
    {

        if ($this->report) {
            $this->TF->db->select($this->report_select);
        } else {

            $this->TF->db->distinct();
            $this->TF->db->select(implode(', ', $this->select_columns));
        }

        $this->TF->db->from('booking_events');
        $this->TF->db->join('booking_items', 'booking_items.booking_item_id = booking_events.booking_item_id', 'left');
        $this->TF->db->join('items', 'booking_items.item_id = items.item_id', 'left');
        $this->TF->db->join('item_categories', 'items.item_id = item_categories.item_id', 'left');
        $this->TF->db->join('categories', 'item_categories.category_id = categories.cat_id', 'left');
        $this->TF->db->join('bookings', 'bookings.booking_id = booking_items.booking_id', 'left');
        $this->TF->db->join('contacts guests', 'bookings.guest_id = guests.contact_id', 'left');
        $this->TF->db->join('facilities', 'facilities.facility_id = booking_events.facility_id', 'left');
        $this->TF->db->join('locations', 'categories.location_id = locations.location_id', 'left');
        $this->TF->db->join('facilities rooms', 'rooms.facility_id = bookings.room_id', 'left');
        $this->TF->db->join('packages', 'bookings.package_id = packages.package_id', 'left');
        $this->TF->db->join('package_types', 'packages.package_type_id = package_types.package_type_id', 'left');


        if ($this->event_id) {
            $this->TF->db->where('booking_events.event_id', $this->event_id);
        } else {

            if ($this->unassigned_only) {
                $this->TF->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id', 'left');
                $this->TF->db->where('(booking_event_users.staff_id IS NULL OR booking_event_users.staff_id = 0)');
            } else {
                if ($this->provider_id) {
                    $this->TF->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id');
                    $this->TF->db->where('booking_event_users.staff_id', $this->provider_id);
                }
            }

            if ($this->booking_id) {
                if (!is_array($this->booking_id)) {
                    $booking_id = array($this->booking_id);
                }

                $this->TF->db->where_in('bookings.booking_id', $booking_id);


                if ($this->status) {
                    if (!is_array($this->status)) {
                        $this->status = array($this->status);
                    }
                    $this->TF->db->where_in('bookings.status', $this->status);
                }
            }


            if ($this->guest_id) {
                if (!is_array($this->guest_id)) {
                    $this->guest_id = array($this->guest_id);
                }
                $this->TF->db->where('bookings.guest_id IN (' . implode(', ', $this->guest_id) . ')');
            }


            if ($this->start) {
//                $this->TF->db->where("DATE_FORMAT(tf_booking_events.start_dt, '%Y-%m-%d') BETWEEN '{$this->start}' AND '{$this->end}'");
                $this->TF->db->where("tf_booking_events.start_dt BETWEEN '{$this->start}' AND '{$this->end}'");
            }

            if ($this->event_status) {
                if (!is_array($this->event_status)) {
                    $this->event_status = array($this->event_status);
                }
                $this->TF->db->where_in('booking_events.status', $this->event_status);
            }

            if ($this->upcoming) {

                $start = new DateTime();
                $end = new DateTime();
                $end->add(new DateInterval($this->upcoming_duration));

                $this->start = $start->format('Y-m-d H:i:s');
                $this->end = $end->format('Y-m-d H:i:s');
                $this->TF->db->where("tf_booking_events.end_dt BETWEEN '{$this->start}' AND '{$this->end}'");
            }

            if ($this->categories) {
                $this->TF->db->where_in('categories.cat_id', $this->categories);
            }
            if ($this->locations) {

                if (!is_array($this->locations)) $this->locations = array($this->locations);
                $this->TF->db->where_in('categories.location_id', $this->locations);
            }

            $this->TF->db->where('booking_events.deleted', 'n');
        }

        if ($this->report_group_by) {
            $this->TF->db->group_by($this->report_group_by);
        }

        if ($this->group_by) {
            $this->TF->db->group_by($this->group_by);
        }

        $this->TF->db->order_by($this->order_by, 'ASC');

        $this->TF->db->limit($this->limit);

        $query = $this->TF->db->get();

        return $query;
    }

    public function build_report()
    {
        $query = $this->query();

        $results = $query->result_array();

        foreach ($results as $result) {
            $this->events[] = $result;
        }
    }

    public function get_count($params) {

        $this->__construct($params);

        $this->report = true;
        $this->report_select = 'COUNT(tf_items.item_id) as c';
        $query = $this->query();
        $count = $query->row_array();
        return $count['c'];
    }

    public function build()
    {
        $query = $this->query();
        $results = $query->result_array();

        $events = array();

        for ($i = 0; $i < count($results); $i++) {

            $classNames = array();
            $results[$i]['id'] = (int)$results[$i]['event_id'];

            $results[$i]['title'] = $results[$i]['event_title'];
            $results[$i]['editable'] = false;
            $results[$i]['overlap'] = false;

            if ($results[$i]['location_id'] !== null && current_user_can('can_edit_schedules_' . $results[$i]['location_id'])) {
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

            $resource_names = array();
            $event_users = get_event_users($results[$i]['event_id']);
            $results[$i]['users'] = $event_users;
            if ($this->resource_fld_name === 'contact_id') {
                $resourceIds = array();
                if ($event_users) {
                    foreach ($event_users as $user) {
                        $resourceIds[] = $user['contact_id'];
                        $resource_names[] = $user['first_name'];
                    }
                }

                $results[$i]['provider'] = implode(',', $resource_names);
                if ($resourceIds)
                    $results[$i]['resourceIds'] = $resourceIds;
            } else {
                if (isset($results[$i][$this->resource_fld_name]))
                    $results[$i]['resourceId'] = $results[$i][$this->resource_fld_name];
            }

            $status = url_title($results[$i]['status'], 'underscore');

            if ($status === 'receptionist') {
                $results[$i]['event_title'] = 'Receptionist';
            }

            $classNames[] = 'fc-event-status-' . $status;

            $titles = array();

            if ($results[$i]['item_abbr'] && $this->abbreviate) {
                $titles[] = $results[$i]['item_abbr'];
            } elseif ($results[$i]['item_name']) {
                $titles[] = $results[$i]['item_name'];
            }

            if ($this->show_facility_name) {
                if ($results[$i]['facility_abbr'] && $this->abbreviate) {
                    $titles[] = $results[$i]['facility_abbr'];
                } elseif ($results[$i]['facility_name']) {
                    $titles[] = $results[$i]['facility_name'];
                }
            }

            $results[$i]['titles'] = $titles;

            if ($this->show_guest_name) {
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

        $this->events = $events;
    }

    public function get_events()
    {
        return $this->events;
    }
}