<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Items extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'description' => array(
				'type' => 'TEXT'),
			'duration' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'constraint' => 5),
			'amount' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'constraint' => 5),
			'uom' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
			),
			));
		$this->dbforge->add_key('item_id', TRUE);
		$this->dbforge->create_table('items');
		
		$this->dbforge->add_field(array(
			'cat_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'cat_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'cat_image' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'parent_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'location_id' => array(
				'type' => 'INT',
				'constraint' => 5)
		));
		$this->dbforge->add_key('cat_id', TRUE);
		$this->dbforge->create_table('categories');
		
		$this->dbforge->add_field(array(
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'category_id' => array(
				'type' => 'INT',
				'constraint' => 5),
		));
		$this->dbforge->add_key('category_id', TRUE);
		$this->dbforge->add_key('item_id', TRUE);
		$this->dbforge->create_table('item_categories');

		$this->dbforge->add_field(array(
			'package_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'package_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255),
			'duration' => array(
				'type' => 'SMALLINT',
				'constraint' => 3,
			),
		));
		$this->dbforge->add_key('package_id', TRUE);
		$this->dbforge->create_table('packages');

		$this->dbforge->add_field(array(
			'package_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				),
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'quantity' => array(
				'type' => 'INT',
				'unsigned' => true,
				'constraint' => 5)
		));
		$this->dbforge->add_key('package_id', TRUE);
		$this->dbforge->add_key('item_id', TRUE);
		$this->dbforge->create_table('package_items');
		
		$this->dbforge->add_field(array(
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				),
			'contact_id' => array(
				'type' => 'INT',
				'constraint' => 5),
		));
		$this->dbforge->add_key('item_id', TRUE);
		$this->dbforge->add_key('contact_id', TRUE);
		$this->dbforge->create_table('items_related_users');

		$this->load->helper('csv');

		$this->db->insert_batch('items', csv_to_array(dirname(__FILE__).'/import_items.csv'));

		$this->db->insert_batch('categories', csv_to_array(dirname(__FILE__).'/import_categories.csv'));

		$this->db->insert_batch('item_categories', csv_to_array(dirname(__FILE__).'/import_items_cat.csv'));

		$this->db->insert_batch('packages', csv_to_array(dirname(__FILE__).'/import_packages.csv'));

		$this->db->insert_batch('package_items', csv_to_array(dirname(__FILE__).'/import_package_items.csv'));
	}
	
	public function down()
	{
		$this->dbforge->drop_table('items');
		$this->dbforge->drop_table('categories');
		$this->dbforge->drop_table('item_categories');
		$this->dbforge->drop_table('packages');
		$this->dbforge->drop_table('package_items');
		$this->dbforge->drop_table('items_related_users');
	}
}
