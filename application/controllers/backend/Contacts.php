<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends TF_Controller {
	
	private $view = 'guest';
	
	public function guest() {
		$this->view = 'guest';
		$this->index();
	}
	
	public function provider() {
		$this->view = 'provider';
		$this->index();
	}
	
	public function json() {
		        
        $this->db->select('contacts.*');
        $this->db->join('users', 'contacts.contact_id = users.contact_id', 'left');
        $this->db->join('groups', 'users.group_id = groups.group_id', 'left');

        if ($keyword = $this->input->get_post('keyword')) {
            $this->db->where("(
                first_name LIKE '%$keyword%' OR 
                last_name LIKE '%$keyword%' OR 
                email LIKE '%$keyword%' OR 
                CONCAT(first_name, ' ', last_name) LIKE '%$keyword%' OR 
                CONCAT(last_name, ' ', first_name) LIKE '%$keyword%')");
        }

        if ($this->view === 'guest')  {
	        $this->db->where('(users.group_id = 5 OR users.group_id IS NULL)');
	    }
	    elseif ($this->view === 'provider') {
	        $this->db->where('groups.include_in_provider_list', 'y');
	    }

        $this->db->where('contacts.deleted = 0');        
        $this->db->order_by('contacts.first_name', 'ASC');        
		$result = $this->db->get('contacts')->result_array();
		
/*
		$output = array();
		
		foreach ($result as $row) {
			$output[] = $row['first_name'] . ' '  . $row['last_name'];
		}
*/
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

    public function index()
    {
        if (!$this->session->has_userdata('user_id'))
        {
            redirect('login');
        }
                
        $active_booking = false;
        
        $inner_s = "SELECT bookings.booking_id 
                    FROM tf_bookings bookings 
                    WHERE bookings.guest_id = tf_contacts.contact_id AND bookings.status IN ('confirmed')";
        
        $booking_start = $this->input->get_post('booking_start');            
        $booking_end = $this->input->get_post('booking_end');
        
        if ($booking_start && $booking_end) {
	        
	        if ($booking_start === $booking_end) {
		        $inner_s .= " AND DATE_FORMAT(from_unixtime(bookings.start_date), '%Y-%m-%d') = '{$booking_start}'";		        
	        }
	        else {
		        $inner_s .= " AND DATE_FORMAT(from_unixtime(bookings.start_date), '%Y-%m-%d') BETWEEN '{$booking_start}' AND '{$booking_end}'";
			}        
	        $active_booking = true;
        }            
        
        $inner_s .= ' LIMIT 1';
        
        // total guest
        $this->db->select('COUNT(*) as total_guest, ('.$inner_s.') as recent_booking');
        $this->db->join('users', 'contacts.contact_id = users.contact_id', 'left');
        $this->db->join('groups', 'users.group_id = groups.group_id', 'left');
        if ($keyword = $this->input->get_post('keyword')) {
        	$this->db->where("(first_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' OR email LIKE '%$keyword%')");
        }
        
        if ($this->view === 'guest')  {
	        $this->db->where('(users.group_id = 5 OR users.group_id IS NULL)');
	    }
	    elseif ($this->view === 'provider') {
	        $this->db->where('groups.include_in_provider_list', 'y');
            if (!is_admin())
	            $this->db->where_in('users.location_id', $this->session->userdata('location_id'));
	    }
	        
        $this->db->where('contacts.deleted = 0');
        if ($active_booking) {
        	$this->db->having('recent_booking > ', 0);
        }
        
        $total_guest = $this->db->get('contacts')->row_array()['total_guest'];
        
        $this->db->select('contacts.*, ('.$inner_s.') as recent_booking, groups.group_name');
        $this->db->join('users', 'contacts.contact_id = users.contact_id', 'left');
        $this->db->join('groups', 'users.group_id = groups.group_id', 'left');

        if ($keyword = $this->input->get_post('keyword')) {
            $this->db->where("(first_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' OR email LIKE '%$keyword%')");
        }

        if ($this->view === 'guest')  {
	        $this->db->where('(users.group_id = 5 OR users.group_id IS NULL)');
	    }
	    elseif ($this->view === 'provider') {
	        $this->db->where('groups.include_in_provider_list', 'y');
            if (!is_admin())
	            $this->db->where_in('users.location_id', $this->session->userdata('location_id'));
	    }

        $this->db->where('contacts.deleted = 0');
		if ($active_booking) {
        	$this->db->having('recent_booking > ', 0);
        }
        $this->db->order_by('contacts.first_name', 'ASC');
        
        $page =intval($this->input->get_post('p'));
        $this->db->limit(15, $page);
        
        $this->load->library('pagination');
        
        $config['base_url'] = site_url('backend/contacts/'.$this->view);
        $config['total_rows'] = $total_guest;
        $config['per_page'] = 15;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['query_string_segment'] = 'p';
        $config['reuse_query_string'] = FALSE;
        
        $this->pagination->initialize($config);
        
        $data['pagination_links'] = $this->pagination->create_links();
        $data['contacts'] = $this->db->get('contacts')->result_array();

        $data['view'] = $this->view;

        $this->load->view('admin/contacts/index', $data);
    }
}
