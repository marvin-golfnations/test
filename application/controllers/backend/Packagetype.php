<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packagetype extends TF_Controller {

    public function submit() {

        $id = (int)$this->input->get_post('id');

        $data = array(
            'package_type_name' => $this->input->get_post('name'),
            'description' => $this->input->get_post('description'),
        );

        $config = get_upload_config(1);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('package_image')) {
            $file = $this->upload->data();

            $this->db->insert('files', array(
                'title' => $file['file_name'],
                'file_name' => $file['file_name'],
                'file_size' => $file['file_size'],
                'upload_id' => 1,
                'upload_date' => now(),
            ));

            $data['package_image'] = (int)$this->db->insert_id();
        }
        else {
            echo $this->upload->display_errors('', '');
            $this->session->set_flashdata('error_message', $this->upload->display_errors('', ''));
        }

        if($id) {
            $this->db->update('package_types', $data, 'package_type_id=' . $id);
        }
        else {
            $this->db->insert('package_types', $data);
        }

        redirect($this->input->get_post('return'));
    }

	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			redirect('login');
		}

		$this->db->select('package_types.*');
		$this->db->from('package_types');
		
		$this->db->order_by('package_types.package_type_name', 'asc');

		$categories = $this->db->get();

		$data = array();
		$data['packagetypes'] = $categories->result_array();


		$this->load->view('admin/package_type/index', $data);
	}

	function edit() {
        if (!$this->session->has_userdata('user_id'))
        {
            redirect('login');
        }

        $id = (int)$this->uri->segment(4);

        $data = array(
            'package_type_id' => 0,
            'package_type_name' => '',
            'description' => '',
            'package_image' => 0,
        );

        $query = $this->db->get_where('package_types', 'package_type_id='.$id);
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        $this->load->view('admin/package_type/form', $data);
    }
}
