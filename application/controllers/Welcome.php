<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends TF_Controller {



	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}
		
		$this->load->library('Eventsbuilder');
		
		$days = createDateRangeArray(date('Y-m-d', strtotime('-7 days')), date('Y-m-d'));
		
		$sales_by_day = array();	
		$sales_by_month = array();	
		
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
		$inline_js = array();
		$sales_today = array();
		foreach ($locations as $location) {
			
			$params = array();
			$params['start'] = $start_date;
			$params['end'] = $end_date;
			$params['locations'] = $location['location_id'];
			$result = $this->eventsbuilder->build_sales($params);
			
			foreach ($days as $day) {
				$sales_by_day[$location['location_id']][$day] = array(0, 0);
			}
			
			
			if ($result) {
				
				
				if (!$result) continue;
				
				if (isset($result['monthly_sales']) && isset($result['monthly_sales'][$current_month])) {
					$monthly_sales += $result['monthly_sales'][$current_month]['total'];
				}
				
				if (isset($result['daily_sales'])) {
					foreach ($result['daily_sales'] as $date => $data) {
						if (in_array($date, $days)) {
							$sales_by_day[$location['location_id']][$date] = array($data['included'], $data['upsell']);
							
							if ($date === $current_date) {
								$sales_today[$location['location_id']] = array($data['included'], $data['foc'], $data['upsell']);
							}
						}
					}
				}
				
				if (isset($result['monthly_sales'])) {
					foreach ($result['monthly_sales'] as $month => $data) {
						$sales_by_month[$location['location_id']][$month] = array($data['included'], $data['upsell']);
					}
				}
				
				if (isset($result['daily_sales'][$current_date])) {
					$daily_sales += $result['daily_sales'][$current_date]['total'];
				}
				
				$sales[$location['location_id']] = $result;
			}
		}
		
		$months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
		
		
		$inline_js['months_value'] = new stdClass();
		$inline_js['months_label'] = array_values($months);
		
		foreach ($sales_by_day as $location_id => $sales) {
			$inline_js['days_label'][(int)$location_id] = array_keys($sales);
			
			$val = array_values($sales);
			
			$included = array();
			$foc = array();
			
			foreach ($val as $i => $n) {
				$included[$i] = $n[0];
				$foc[$i] = $n[1];
			}			
			$inline_js['days_value'][(int)$location_id] = array($included, $foc);
		}
		
		foreach ($sales_by_month as $location_id => $sales) {			
			$val = array_values($sales);
			$included = array();
			$foc = array();
			
			foreach ($val as $i => $n) {
				$included[$i] = $n[0];
				$foc[$i] = $n[1];
			}			
			
			
// 			$inline_js['months_value'][(int)$location_id] = array($included, $foc);
		}
/*
		
		
		$inline_js = array(
			'days_label' => array_keys($sales_by_day),
			'days_value' => array_values($sales_by_day)
		);
		
*/
		
		$colors = array(
			1 => 'green',
			2 => 'green-sea',
			3 => 'sun-flower',
			7 => 'alizarin',
		);
		
		$icons = array(
			1 => 'fa fa-heartbeat',
			2 => 'md md-directions-walk',
			3 => 'md md-local-restaurant',
			7 => 'green',
		);
		
		$stats['sales'] = $sales;
		$stats['sales_today'] = $sales_today;
		
		$inline_js['sales_today'] = $sales_today;
		
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

		if (is_guest())
			redirect('/account/dashboard/');
		
		if (!current_user_can('can_view_dashboard')) {
			redirect('calendar');
		}	
	}
}
