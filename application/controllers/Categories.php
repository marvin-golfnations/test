<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends TF_Controller {
	function items() {
		
		$category = $this->uri->segment(1);
		//test
		if ($category === 'medical') {
			$category_id = 1;
		}
		elseif ($category === 'spa') {
			$category_id = 2;
		}
		elseif ($category === 'cuisine') {
			$category_id = 3;
		}
		elseif ($category === 'fitness') {
			$category_id = 11;
		}
		elseif ($category === 'rooms') {
			$category_id = 8;
		}

		$data['category_id'] = $category_id;
		$query = $this->db->get_where('categories', 'cat_id='.$category_id);
        $data['category'] = $query->row_array();
		
		$data['categories'] = get_categories($category_id);
		
		$this->db->select('items.*');
		$this->db->join('item_categories', 'items.item_id=item_categories.item_id');
		$this->db->where_in('item_categories.category_id', array($category_id));
		$this->db->where('items.for_sale', 'y');
		
		$query = $this->db->get('items');
		$data['items'] = $query->result_array();
		
		if ($category_id === 8) {
			$this->load->view('rooms', $data);
		}
		else {
			$this->load->view('categories', $data);
		}
	}
}