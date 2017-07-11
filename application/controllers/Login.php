<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends TF_Controller {

	public function index()
	{
		//$this->load->library('facebook');
		$this->load->view('login');
		
		$this->session->sess_destroy();
	}
	
	public function login2()
	{
		//$this->load->library('facebook');
		$this->load->view('login2');
		
		$this->session->sess_destroy();
	}
	
	public function submit() {

		//$this->load->library('facebook');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login');
		}
		else
		{
			$username = $this->input->get_post('username');
			$password = $this->input->get_post('password');

			$this->db->select('contacts.verified, contacts.first_name, contacts.last_name, username, groups.*, users.*, contacts.avatar, contacts.email, contacts.gender');
			$this->db->from('users');
			$this->db->join('contacts', 'contacts.contact_id = users.contact_id');
			$this->db->join('groups', 'groups.group_id = users.group_id');

			$this->db->where('username' , $username);
			$this->db->where('password' , do_hash($password));
			$this->db->where('deleted', 0);

			$query = $this->db->get();

			if ($query->num_rows() === 0)
			{
                $this->show_result('Invalid username / password.', true);
			}


			$data = $query->row_array();
			
			if ($data['group_id'] === 5) {
				if ($data['verified'] === 'n') {
                    $this->show_result('Your account has not been VERIFIED yet. <br /><a href="'.site_url('/register/resend/'.$data['contact_id']).'">Click here to resend email verification</a>', true);
				}
				
				if ($data['approved'] === 'n') {
                    $this->show_result('Your account has not been APPROVED yet.', true);
				}
				
				if ($data['active'] === 'n') {
                    $this->show_result('Your account has not been ACTIVATED yet.', true);
				}
			}

			$data['user_id'] = (int)$data['contact_id'];
			$data['group_id'] = (int)$data['group_id'];
			$data['location_id'] = (int)$data['location_id'];
			$data['location'] = explode(',', $data['location']);
			$data['logged_in'] = TRUE;
			$data['first_name'] = $data['first_name'];
			$data['screen_name'] = $data['first_name'] . ' ' . $data['last_name'];
            $data['calendar_header_right'] = $data['calendar_header_right'];
			$data['default_calendar_view'] = $data['default_calendar_view'];
            $data['calendar_show_no_schedule'] = $data['calendar_show_no_schedule'] === 'y';
            $data['calendar_show_my_schedule_only'] = $data['calendar_show_my_schedule_only'] === 'y';
            $data['calendar_view_status'] = $data['calendar_view_status'] ? explode(',', $data['calendar_view_status']) : array();
            $data['calendar_view_positions'] = $data['calendar_view_positions'] ? explode(',', $data['calendar_view_positions']) : array();
            $data['calendar_view_locations'] = $data['calendar_view_locations'] ? explode(',', $data['calendar_view_locations']) : array();

			$this->session->set_userdata($data);

			$this->db->update('users', array('last_login' => now()), array('contact_id' => $data['user_id']));


            if (in_array($data['group_id'], array(5))) {

				if (isset($_REQUEST['return'])) {
				    $this->show_result('', false, $_REQUEST['return']);
				}
                $this->show_result('', false, '/');
            }
            $this->show_result('', false, '/backend/dashboard');
		}
	}

	function show_result($result, $error = false, $redirect = '') {
        if ($this->input->is_ajax_request()) {
            echo json_encode(array('Error' => $error, 'Message' => $result, 'Redirect' => $redirect));
            exit ( 0 );
        }

        if ($error) {
            show_error($result);
        }
    }
}
