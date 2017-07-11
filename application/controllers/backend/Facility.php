<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facility extends TF_Controller {


	public function index()
	{
		if (!$_POST) return;

		$facility_id = $this->input->get_post('id');

		$data = array(
			'facility_name' => $this->input->get_post('facility_name'),
			'abbr' => $this->input->get_post('abbr'),
			'location_id' => (int)$this->input->get_post('location_id'),
			'status' => (int)$this->input->get_post('status'),
			'max_accomodation' => (int)$this->input->get_post('max_accomodation'),
			'bg_color' => $this->input->get_post('bg_color'),
		);

		if ($facility_id)
		{
			$this->db->update('facilities', $data, array('facility_id' => $facility_id));
		}
		else {
			$this->db->insert('facilities', $data);
			$item_id = $this->db->insert_id();
		}

		redirect('backend/facilities');

	}
	
	public function edit() {

		$data = array(
			'facility_id' => (int)$this->uri->segment(4),
			'facility_name' => '',
			'max_accomodation' => 1,
			'abbr' => '',
			'status' => 1,
			'bg_color' => '#fff',
			'location_id' => $this->session->userdata('location_id'),
			'colors' => array("#5B0F00","#660000","#783F04","#7F6000","#274E13","#0C343D","#1C4587","#073763","#20124D","#4C1130",
		"#5B0F00","#660000","#783F04","#7F6000","#274E13","#0C343D","#1C4587","#073763","#20124D","#4C1130",
		"#85200C","#990000","#B45F06","#BF9000","#38761D","#134F5C","#1155CC","#0B5394","#351C75","#741B47",
		"#A61C00","#CC0000","#E69138","#F1C232","#6AA84F","#45818E","#3C78D8","#3D85C6","#674EA7","#A64D79",
		"#CC4125","#E06666","#F6B26B","#FFD966","#93C47D","#76A5AF","#6D9EEB","#6FA8DC","#8E7CC3","#C27BA0",
		"#DD7E6B","#EA9999","#F9CB9C","#FFE599","#B6D7A8","#A2C4C9","#A4C2F4","#9FC5E8","#B4A7D6","#D5A6BD",
		"#E6B8AF","#F4CCCC","#FCE5CD","#FFF2CC","#D9EAD3","#D0E0E3","#C9DAF8","#CFE2F3","#D9D2E9","#EAD1DC",
		"#980000","#FF0000","#FF9900","#FFFF00","#00FF00","#00FFFF","#4A86E8","#0000FF","#9900FF","#FF00FF",
		"#000000","#222222","#444444","#666666","#888888","#AAAAAA","#CCCCCC","#DDDDDD","#EEEEEE","#FFFFFF", "#99CCFF")
		);

		$query = $this->db->get_where('facilities', array('facility_id' => $data['facility_id']));

		if ($query->num_rows() > 0) {
			$item_data = $query->row_array();
			$data = array_merge($data, $item_data);
		}

		$services = array();
		$data['statuses'] = array(0 => 'Inactive', 1 => 'Active');
		
		if ($data['facility_id'] > 0) {
			$this->db->select('items.*');
			$this->db->from('items');
			$this->db->join('items_related_facilities', 'items_related_facilities.item_id = items.item_id');
			$this->db->where('items_related_facilities.facility_id', $data['facility_id']);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$services = $query->result_array();
			}
		}
		
		$data['services'] = keyval(get_services(), 'item_id', 'title');
		
		$data['related_services'] = $services;
		
		$this->load->view('admin/facility/form', $data);
	}
	
	public function delete() {

		$id = (int)$this->uri->segment(4);
		$confirm = $this->input->get_post('confirm');
		if ($id && $confirm && $confirm === 'y') {
			//check if the item is in use.
			$this->db->select('facilities.facility_name');
			$this->db->from('booking_events');
			$this->db->join('facilities', 'booking_events.facility_id = facilities.facility_id');
			$this->db->where('facilities.facility_id', $id);
			$q = $this->db->get();
			if ($q->num_rows() > 0) {
				$r = $q->row_array();
				show_error($r['facility_name'] . ' is currently in used.');
				return;
			}

			$this->db->delete('facilities', array('facility_id' => $id));

			if ($return = $this->input->get_post('return'))
				redirect($return);
		}

		redirect('backend/facilities');
	}
}
