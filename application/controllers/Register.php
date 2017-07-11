<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends TF_Controller {

	public function index()
	{
		$this->load->library('facebook');
		$this->load->library('FormBuilder');
		
		

		$data = array();
		
		// Check if user is logged in
		if ($this->facebook->is_authenticated())
		{
			// User logged in, get user details
			$user = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email');
			if (!isset($user['error']))
			{
				//check if email address is existing.
				$query = $this->db->get_where('contacts', array('email' => $user['email']));
				if ($query->num_rows() === 0) {
					$data = array(
						'first_name'=>$user['first_name'],
						'last_name' => $user['last_name'],
						'email' => $user['email'],
						'date_joined' => date('Y-m-d')
					);
					$this->db->insert('contacts',$data);

					$contact_id = $this->db->insert_id();

					$data = array(
						'username'=>$user['email'],
						'password'=>do_hash($user['id']),
						'facebook_id' => $user['id'],
						'contact_id' => $contact_id,
						'group_id' => 5,
						'last_login' => now()
					);

					$this->db->insert('users',$data);

					$user_data = array(
						'user_id'  => $contact_id,
						'username' => $user['email'],
						'logged_in' => TRUE,
						'facebook_id' => $user['id'],
						'avatar' => 'https://graph.facebook.com/'.$user['id'].'/picture?type=small',
					);

					$user_data['screen_name'] = $user['first_name'] . ' ' . $user['last_name'];

					$this->session->set_userdata($user_data);

					redirect('/');
				}

				//check if facebook id already exists.
				$this->db->select('users.*, contacts.first_name, contacts.last_name, contacts.email');
				$this->db->from('users, contacts');
				$this->db->where('users.contact_id = contacts.contact_id');
				$this->db->where('facebook_id = '.$user['id']);
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					$_user = $query->row_array();
					$user_data = array(
						'user_id'  => $_user['contact_id'],
						'username' => $_user['username'],
						'logged_in' => TRUE,
						'facebook_id' => $user['id'],
						'avatar' => 'https://graph.facebook.com/'.$user['id'].'/picture?type=small',
					);

					$user_data['screen_name'] = $_user['first_name'] . ' ' . $_user['last_name'];

					$this->session->set_userdata($user_data);
					redirect('/');

				}
			}
		}

/*
		$query = $this->db->get_where('forms', 'form_id = 1');
		$data['form'] = $query->row_array();
		$data['nationalities'] = nationalities();
		$data['countries'] = countries();
*/

		$this->load->view('signup', $data);
	}
	
	public function submit() {

		$this->load->library('FormBuilder');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');



		if ($this->form_validation->run() === FALSE)
		{
			redirect($this->input->get_post('return'));
		}
		else
		{
			$password = $this->input->get_post('password');
			$email = $this->input->get_post('email');
			$username = $email;
			$form_id = (int)$this->input->get_post('form_id');

			$query = $this->db->get_where('users', array('username' => $username));

			if ($query->num_rows() >= 1) {
				show_error('Username already exist!');
			}

			$verification_key = uniqid();
			
			$dob = $this->input->get_post('dob-year') . '-' . $this->input->get_post('dob-month') . '-' . $this->input->get_post('dob-day');
			
			$gender = $this->input->get_post('gender') ? $this->input->get_post('gender') : 'F';
			

			$data = array(
				'first_name' => $this->input->get_post('first_name'),
				'last_name' => $this->input->get_post('last_name'),
				'middle_name' => $this->input->get_post('middle_name'),
				'email' =>  $email,
				'dob' => $dob,
// 				'gender' => $gender,
				'place_of_birth' => $this->input->get_post('place_of_birth'),
 				'phone' => $this->input->get_post('phone'),
				'date_joined' => now(),
				'verification_key' => $verification_key,
				'verified' => 'n',
				'approved' => 'n',
				'active' => 'n',
			);

			// create contact
			$this->db->insert('contacts', $data);

			$contact_id = $this->db->insert_id();

			$this->db->insert('users',array(
				'username' => $username,
				'password' => do_hash($password),
				'contact_id' => $contact_id,
				'group_id' => 5
			));

			$user_data = array(
				'user_id'  => $contact_id,
				'username' => $username,
				'logged_in' => TRUE
			);

			$user_data['screen_name'] = $data['first_name'] . ' ' . $data['last_name'];

			$this->send_verification_email($data, $contact_id, $verification_key);
			
			$this->session->set_flashdata('message', 'You need to verify your account.');
			
			redirect($this->input->get_post('return'));
		}
	}
	
	public function submit1() {

		$this->load->library('FormBuilder');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');



		if ($this->form_validation->run() === FALSE)
		{
			$data = array();
/*
			$query = $this->db->get_where('forms', 'form_id = 1');
			$data['form'] = $query->row_array();
			$data['nationalities'] = nationalities();
			$data['countries'] = countries();
*/

			$this->load->view('signup', $data);
		}
		else
		{
			$password = $this->input->get_post('password');
			$username = $this->input->get_post('username');
			$email = $this->input->get_post('email');
			$form_id = (int)$this->input->get_post('form_id');

			$query = $this->db->get_where('users', array('username' => $username));

			if ($query->num_rows() >= 1) {
				show_error('Username already exist!');
			}

			$verification_key = uniqid();

			$data = array(
				'first_name' => $this->input->get_post('first_name'),
				'last_name' => $this->input->get_post('last_name'),
// 				'title' =>  $this->input->get_post('title'),
				'email' =>  $email,
// 				'civil_status' => $this->input->get_post('civil_status'),
// 				'nationality' => $this->input->get_post('nationality'),
// 				'country_dominicile' => $this->input->get_post('country_dominicile'),
// 				'etnic_origin' => $this->input->get_post('etnic_origin'),
// 				'dob' => date('Y-m-d', strtotime($this->input->get_post('dob'))),
// 				'age' => $this->input->get_post('age'),
// 				'gender' => $this->input->get_post('gender'),
// 				'height' => $this->input->get_post('height'),
// 				'weight' => $this->input->get_post('weight'),
// 				'phone' => $this->input->get_post('phone'),
				'date_joined' => date("Y-m-d"),
				'verification_key' => $verification_key,
				'verified' => 'n'
			);

			// create contact
			$this->db->insert('contacts', $data);

			$contact_id = $this->db->insert_id();

			$this->db->insert('users',array(
				'username' => $username,
				'password' => do_hash($password),
				'contact_id' => $contact_id,
				'group_id' => 5
			));

			$user_data = array(
				'user_id'  => $contact_id,
				'username' => $username,
				'logged_in' => TRUE
			);

			$user_data['screen_name'] = $data['first_name'] . ' ' . $data['last_name'];

/*
			$form_data = array(
				'entry_date' => now(),
				'author_id' => $contact_id,
			);

			$table_name = 'form_entries_' . $form_id;
			$this->load->dbforge();
			foreach ($_REQUEST as $field => $value) {
				if (strpos($field, 'field_id_') === 0) {
					if (!$this->db->field_exists($field, $table_name)) {
						$this->dbforge->add_column($table_name, array(
							$field => array('type' => 'text')
						), 'booking_id');
					}
					$form_data[$field] = is_array($value) ? implode('|', $value) : $value;
				}
			}

			$this->db->insert($table_name, $form_data);
*/

			$this->send_verification_email($data, $contact_id, $verification_key);
			
			$this->session->set_flashdata('message', 'You need to verify your account.');
			
			redirect('login');
		}
	}

	function verify() {
		$contact_id = (int)$this->uri->segment(3);
		$key = $this->uri->segment(4);

		$query = $this->db->get_where('contacts', 'contact_id='.$contact_id.' AND verification_key=\''.$key.'\' AND verified=\'y\'');

		if ($query->num_rows() > 0) {
			show_error('This verification link is either invalid or has expired.');
		}
		
		$this->session->set_flashdata('message', 'Your account is successfully verified.');
		
		$this->db->update('contacts', array('verified' => 'y'), 'contact_id='.$contact_id);
		
		$q = $this->db->get_where('contacts', 'contact_id='.$contact_id);
		$data = $q->row_array();
		
		$this->load->library('email');
		$this->email->from('jay_cruz@thefarm.com.ph', 'The Farm at San Benito');		
		$this->email->to('jay_cruz@thefarm.com.ph');
		$this->email->set_header('From', $data['email']);
		$this->email->subject('Notification of new guest registration');
		$this->email->message('New guest registration:'.'<br/>'.
			'<p>'.
			'Name: '.$data['first_name'] . ' ' . $data['last_name'].'<br />'.
			'Email: '.$data['email'].'</p>');
					
		redirect('/');
	}

	function resend() {
		$contact_id = (int)$this->uri->segment(3);

		$query = $this->db->get_where('contacts', 'contact_id='.$contact_id);

		if ($query->num_rows() === 0) {
			show_error('This link is either invalid or has expired.');
		}

		$contact_data = $query->row_array();

		if ($contact_data['verified'] === 'y') {
			show_error('This account is already verified.');
		}

		$verification_key = uniqid();

		$this->db->update('contacts', array('verification_key' => $verification_key), 'contact_id='.$contact_id);
		
		$this->send_verification_email($contact_data, $contact_id, $verification_key);

		$data = array();
		$data['title'] = 'Verify Your Email Address';
		$data['message'] = sprintf(
			'We now need to verify your email address. We\'ve sent an email to %s to verify your address. Please click the link in that email to continue.',
			$contact_data['email']
		);

		$this->load->view('verify', $data);
	}

	/**
	 * @param $email
	 * @param $contact_id
	 * @param $verification_key
	 */
	private function send_verification_email($data, $contact_id, $verification_key)
	{
		$this->load->library('email');

		// notify guest.
		$this->email->to($data['email']);
		$this->email->from('jay_cruz@thefarm.com.ph', 'The Farm at San Benito');
		$this->email->subject('Verify your TheFarm account');
		$this->email->message(
			'Hi ' . $data['first_name'] . ' ' . $data['last_name'] . "," .
			'<p>Welcome to TheFarm!</p>' .
			'<p>Please complete your account by verifying your email address.</p>' .
			'<p><a href="' . site_url('register/verify/' . $contact_id . '/' . $verification_key) . '">VERIFY EMAIL</a>' . "</p>" .
			'<p>If the link above doesn\'t work, you can copy and paste the following into your browser:</p>' .
			'<p>' . site_url('register/verify/' . $contact_id . '/' . $verification_key) . '</p>'
		);
		
		$this->email->send();

	}

}
