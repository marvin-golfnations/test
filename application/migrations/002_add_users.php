<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Users extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'contact_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'),
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'last_login' => array(
				'type' => 'INT',
				'constraint' => 10,
				'nullable' => true),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'),
			'work_plan' => array(
				'type' => 'TEXT',
			),
			'location_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'default' => 0
			),
			'facebook_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
			'order' => array(
				'type' => 'INT',
				'constraint' => 5,
				'default' => 0
			),
		));
		$this->dbforge->add_key('contact_id', TRUE);
		$this->dbforge->create_table('users');
		
		$this->load->helper('security');
		
		$data = array(
		  'username' => 'admin',
		  'password' => do_hash('admin'),
		  'group_id' => 1,
		  'contact_id' => 1
		);
		
		$this->db->insert('users', $data);
	}
	
	public function down()
	{
		$this->dbforge->drop_table('users');
	}
}
