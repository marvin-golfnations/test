<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends TF_Controller {



	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}
		
		$this->load->library('Eventsbuilder');
		
		$days = createDateRangeArray(date('Y-m-d', strtotime('-7 days')), date('Y-m-d'));
		
		$sales_by_day = array();
		foreach ($days as $day) {
			$sales_by_day[$day] = 0;
		}
		
		
		
		$current_month = date('n');
		$current_date = date('Y-m-d');
		$locations = get_all_locations();
		$start_date = date('Y-01-01');
		$end_date = date('Y-12-31');
		$sales = array();
		$monthly_sales = 0;
		$daily_sales = 0;
		$stats = array();
		$daily = array();
		foreach ($locations as $location) {
			
			$params = array();
			$params['start'] = $start_date;
			$params['end'] = $end_date;
			$params['locations'] = $location['location_id'];
			$result = $this->eventsbuilder->build_sales($params);
			
			if ($result) {
			
				if (!$result) continue;
				
				if (isset($result['monthly_sales']) && isset($result['monthly_sales'][$current_month])) {
					$monthly_sales += $result['monthly_sales'][$current_month]['total'];
				}
				
				if (isset($result['daily_sales'])) {
					foreach ($result['daily_sales'] as $date => $data) {
						if (in_array($date, $days)) {
							$sales_by_day[$date] = $data['total'];
						}
					}
				}
				
				if (isset($result['daily_sales'][$current_date])) {
					$daily_sales += $result['daily_sales'][$current_date]['total'];
				}
				
				$sales[$location['location_id']] = $result;
			}
		}
		
		$inline_js = array(
			'days_label' => array_keys($sales_by_day),
			'days_value' => array_values($sales_by_day)
		);
		
		
		$colors = array(
			1 => 'green',
			2 => 'green-sea',
			3 => 'sun-flower',
		);
		
		$icons = array(
			1 => 'fa fa-stethoscope',
			2 => 'fa fa-heart-o',
			3 => 'fa fa-food'
		);
		
		$stats['sales'] = $sales;
		
		$data = array();
		$data['icons'] = $icons;
		$data['colors'] = $colors;
		$data['stats'] = $stats;
		$data['inline_js'] = $inline_js;
		$data['current_month'] = date('F');
		$data['locations'] = $locations;
		$data['current_date'] = date('Y-m-d');
		$data['monthly_sales'] = $monthly_sales;
		$data['daily_sales'] = $daily_sales;
		$this->load->view('welcome_message', $data);		
	}
	
	public function daily() {

		$start =  $this->uri->segment(4) ? $this->uri->segment(4) : date('Y-m-d');
		$end =  $this->uri->segment(4) ? $this->uri->segment(4) : date('Y-m-d');
		$select_locations = $this->uri->segment(4);
		if ($this->input->get_post('start')) $start = $this->input->get_post('start');
		if ($this->input->get_post('end')) $end = $this->input->get_post('end');
		if ($this->input->get_post('locations')) $select_locations = $this->input->get_post('locations');
		
		$params = array();
		$params['start'] = $start;
		$params['end'] = $end;
		$params['order_by'] = 'start_dt';
		$params['locations'] = $select_locations;
		$this->load->library('Eventsbuilder', $params);
		$this->eventsbuilder->build();
		
		$inline_js = array(
			'start_date' => date('Y-m-d', strtotime($start)),
			'end_date' => date('Y-m-d', strtotime($end))
		);
		
		$locations = array();
		$all_locations = get_all_locations();
				
		foreach ($all_locations as $loc) {
			$locations[$loc['location_id']] = $loc['location'];
		}
		
		$data['inline_js'] = $inline_js;
		$data['locations'] = $locations;
		$data['selected_locations'] = $select_locations;
		$data['data'] = $this->eventsbuilder->get_events();
		$data['date'] = $params['start'];
		$data['start'] = $params['start'];
		$data['end'] = $params['end'];
		$data['location'] = $params['locations'];
		
				
		$this->load->view('admin/reports/daily', $data);		
	}
	
	public function monthly() {

		$params = array();
		$params['start'] = $this->uri->segment(4);
		$params['end'] = $this->uri->segment(4);
		$params['locations'] = (int)$this->uri->segment(4);
		$params['order_by'] = 'guests.contact_id';
		$this->load->library('Eventsbuilder', $params);
		$this->eventsbuilder->build();
		
		$data['data'] = $this->eventsbuilder->get_events();
		$data['date'] = $params['start'];
		$data['location'] = $params['locations'];
		$data['months'] = get_months();
		$data['group_by'] = 'items.item_id';
		$data['years'] = array(2010 => 2010, 2011 => 2011, 2012 => 2012, 2013=>2013, 2014=>2014, 2015=>2015, 2016=>2016);
		
				
		$this->load->view('admin/reports/monthly', $data);		
	}
	
	public function pdf() {

		$params = array();
		$params['start'] = $this->uri->segment(4);
		$params['end'] = $this->uri->segment(4);
		$params['locations'] = (int)$this->uri->segment(4);
		$this->load->library('Eventsbuilder', $params);
		$this->eventsbuilder->build();
		
		$query = $this->db->get_where('locations', 'location_id='.$params['locations']);
		$location = $query->row_array();
		
		$data['data'] = $this->eventsbuilder->get_events();
		$data['location_name'] = $location['location'];
		$data['date'] = date('d-M-y', strtotime($this->uri->segment(4)));
		$this->load->view('admin/reports/daily-print', $data);		
	}
	
	
}
