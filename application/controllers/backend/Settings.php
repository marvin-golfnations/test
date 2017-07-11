<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends TF_Controller {
	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}
		$this->load->view('admin/settings/index');
	}
	
	public function configuration() {
		
		$site = $this->db->get('sites')->row_array();
		
		$pref = json_decode($site['site_system_preferences'], true);
		
		if ($_POST) {
			
			$new_site_pref = $_POST['preferences'];
			
			$pref = array_merge($pref, $new_site_pref);
			
			$this->db->update('sites', array('site_system_preferences' => json_encode($pref)), array('site_id' => $this->input->get_post('site_id')));
		}
		
		if ($pref['upload_path'] === '') {
			$pref['upload_path'] = realpath(dirname(BASEPATH)) . '/images/avatars/';
		}

		if (!isset($pref['start_time'])) {
			$pref['start_time'] = '';
			$pref['end_time'] = '';
		}
		
		$data['preferences'] = $pref;
		$data['site_id'] = $site['site_id'];
		
		$this->load->view('admin/settings/configuration', $data);
	}
}
