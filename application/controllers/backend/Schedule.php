<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends TF_Controller {

    public function index() {
        $this->view();
    }

    public function view() {

        $contact_id = (int)$this->uri->segment(4);
        $week = $this->uri->segment(5);
        if (!$week) $week = date('Y-m-d');

		$providers = get_provider_list(false, false, false, $this->session->userdata('location_id'));
		$providers_arr = array('' => '-Select-');
        $providers_arr = keyval($providers, 'contact_id', array('first_name', 'last_name'), 'position', $providers_arr);
		
        if ($contact_id === 0) {
            $ids = array_keys($providers_arr);
            $contact_id = $ids[0];
        }
		
        $data['providers'] = $providers_arr;

        $data['contact_id'] = $contact_id;

        $data['week'] = $week;

        $query = $this->db->get_where('users', 'contact_id='.(int)$contact_id);

        $result = $query->row_array();

        $params['date'] = $week;
        $params['base'] = 'backend/schedule/view/'.$contact_id;
        $params['schedule'] = $result['work_plan'] ? unserialize($result['work_plan']) : false;
        $params['schedule_code'] = $result['work_plan_code'] ? unserialize($result['work_plan_code']) : false;

        $this->load->library('weeklycalendar', $params);

        $this->load->view('admin/schedule/index', $data);
    }

    public function check() {
        $date = $this->input->get_post('date');
        $contact_id = $this->input->get_post('contact_id');
        $code = $this->input->get_post('code');

        if ($code === 'custom') {
            $this->output->set_content_type('application/json')->set_output(json_encode(array()));
            return;
        }

        if (in_array($code, explode(',', '1,2,3,4,5,6,7,8,9,10,A,B,C,D'))) {

            $codes = get_schedule_codes();
            list($time_from, $time_to) = explode(' - ', $codes[$code]);
            if (!$time_from) $time_from = '00:00:00';
            if (!$time_to) $time_to = '23:59:59';
            
            $time_from_tm = strtotime($time_from);
            $time_to_tm = strtotime($time_to);
            if ($time_to_tm < $time_from_tm) {
	            $time_to_tm = strtotime('+1 day', $time_to_tm);
            }

            $time_range = array();
            $time = mktime(0, 0, 0, 1, 1);
            for ($i = $time_from_tm; $i < $time_to_tm; $i += 1800) {  // 1800 = half hour, 86400 = one day

                $tm = $i; //$time + $i;
                // var_dump(date('c', $tm));
                
                $t2 = sprintf('%1$s', date('H:i', $tm));
                $time_range[] = $t2;
            }

            $output = array($date => $time_range);

            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
        else {

//            $start = date('Y-m-d H:i:s', strtotime($date . ' 00:00:00'));
//            $end = date('Y-m-d H:i:s', strtotime($date . ' 23:59:59'));
//
//            $this->db->select('*');
//            $this->db->join('booking_event_users', 'booking_events.event_id = booking_event_users.event_id');
//            $this->db->where_in('booking_event_users.staff_id', $contact_id);
//            $this->db->where_not_in('status', array('cancelled', 'no-show'));
//            $this->db->where("'{$start}' <= DATE_SUB(end_dt, INTERVAL 1 MINUTE) AND '{$end}' >= start_date");
//            $query = $this->db->get('booking_events');
//
//            if ($query->num_rows() > 0) {
//
//            }
        }
    }

    public function update () {

        $schedule = array();
        $schedule_code = array();
        foreach ($_POST['schedule_day'] as $date => $code)
        {
            $schedule[$date] = isset($_POST['schedule'][$date]) ? $_POST['schedule'][$date] : array();

            if ($code !== '') {
                if (in_array($code, explode(',', '1,2,3,4,5,6,7,8,9,10,A,B,C,D'))) {
                    if (isset($_POST['schedule'][$date])) {
                        $schedule[$date] = $_POST['schedule'][$date];
                    }
                }
                $schedule_code[$date] = $code;
            }

        }

        $contact_id = (int)$this->input->get_post('contact_id');
        $week = $this->input->get_post('week');

        foreach ($schedule_code as $date => $code) {
	        $this->_insert_or_update_date($contact_id, $date, $code);
        }
        
        foreach ($schedule as $date => $times) { 
	        $this->db->delete('user_work_plan_time', 'contact_id='.$contact_id.' AND start_date BETWEEN \''.$date.' 00:00:00\' AND \''.$date.' 23:59:59\'');
	        foreach ($times as $time) {
		        $this->_insert_or_update_time($contact_id, $date . ' ' . $time . ':00');
	        }
        }
        

        $this->db->update('users', array(
            'work_plan' => serialize($schedule),
            'work_plan_code' => serialize($schedule_code)
        ), array('contact_id' => $contact_id));

        redirect('backend/schedule/view/'.$contact_id.'/'.$week);
    }
    
    private function _insert_or_update_date($contact_id, $date, $code) {
	    $q = $this->db->get_where('user_work_plan_day', 'contact_id='.$contact_id.' AND date=\''.$date.'\'');
	    if ($q->num_rows() > 0) {
		    $this->db->where('contact_id='.$contact_id.' AND date=\''.$date.'\'');
		    $this->db->update('user_work_plan_day', array('work_code' => $code));
	    }
	    else {
			$this->db->insert('user_work_plan_day', array('contact_id' => $contact_id, 'date' => $date, 'work_code' => $code));
	    }
    }
    
    private function _insert_or_update_time($contact_id, $time) {
	    
	    $start_date = new DateTime($time);
	    $end_date = new DateTime($time);
	    $end_date->add(new DateInterval('PT29M'));
	    
	    $q = $this->db->get_where('user_work_plan_time', 'contact_id='.$contact_id.' AND start_date=\''.$start_date->format('Y-m-d H:i:s').'\'');
	    if ($q->num_rows() === 0) {
			$this->db->insert('user_work_plan_time', array('contact_id' => $contact_id, 'start_date' => $start_date->format('Y-m-d H:i:s'), 'end_date' => $end_date->format('Y-m-d H:i:s')));
		}
		else {
			$this->db->delete('user_work_plan_time', 'contact_id='.$contact_id.' AND start_date=\''.$start_date->format('Y-m-d H:i:s').'\'');
		}
    }
}

