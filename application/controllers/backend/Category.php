<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends TF_Controller
{

    public function submit()
    {

        $cat_id = (int)$this->input->get_post('id');

        $data = array(
            'cat_name' => $this->input->get_post('cat_name'),
            'cat_body' => $this->input->get_post('cat_body'),
            'parent_id' => $this->input->get_post('parent_id'),
            'cat_bg_color' => $this->input->get_post('cat_bg_color')
        );

        $config = get_upload_config(1);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('cat_image')) {
            $file = $this->upload->data();

            $this->db->insert('files', array(
                'title' => $file['file_name'],
                'file_name' => $file['file_name'],
                'file_size' => $file['file_size'],
                'upload_id' => 1,
                'upload_date' => now(),
            ));

            $data['cat_image'] = (int)$this->db->insert_id();
        } else {
            $this->session->set_flashdata('error_message', $this->upload->display_errors('', ''));
        }

        if ($cat_id) {
            $this->db->update('categories', $data, 'cat_id=' . $cat_id);
        } else {
            $this->db->insert('categories', $data);
        }

        redirect($this->input->get_post('return'));
    }

    public function index()
    {
        if (!$this->session->has_userdata('user_id')) {
            redirect('login');
        }

        $this->db->select('categories.*');
        $this->db->from('categories');
        if ($this->session->userdata('location_id')) {
            $location = $this->session->userdata('location_id');
            $this->db->where_in('categories.location_id', array(0, $location));
        }

        if ($this->input->get_post('keyword')) {
            $this->db->where("categories.cat_name LIKE '%" . $this->input->get_post('keyword') . "%'");
        }

        $this->db->order_by('categories.parent_id', 'asc');

        $categories = $this->db->get();

        $data = array();
        $data['categories'] = $categories->result_array();


        $this->load->view('admin/category/index', $data);
    }

    function edit()
    {
        if (!$this->session->has_userdata('user_id')) {
            redirect('login');
        }

        $cat_id = (int)$this->uri->segment(4);

        $data = array(
            'cat_id' => 0,
            'cat_name' => '',
            'cat_body' => '',
            'cat_image' => 0,
            'parent_id' => 0,
            'cat_bg_color' => '',
        );

        $query = $this->db->get_where('categories', 'cat_id=' . $cat_id);
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }

        $parent_categories = array(0 => '');
        $parent_categories = keyval(get_parent_categories(), 'cat_id', 'cat_name', false, $parent_categories);

        $data['parent_categories'] = $parent_categories;
        $this->load->view('admin/category/form', $data);
    }

    function delete()
    {
        if (!$this->session->has_userdata('user_id')) {
            redirect('login');
        }


        $cat_id = (int)$this->uri->segment(4);
        $confirm = $this->input->get_post('confirm');
        if ($cat_id && $confirm && $confirm === 'y') {

            $this->db->delete('categories', array('cat_id' => $cat_id));
            $this->db->delete('item_categories', array('category_id' => $cat_id));

            if ($return = $this->input->get_post('return'))
                redirect($return);
        }

        redirect('backend/category');
    }
}
