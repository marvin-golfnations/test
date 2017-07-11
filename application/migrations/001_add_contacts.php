<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Contacts extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'contact_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => ''),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '10',
				'default' => ''),
			'date_joined' => array(
				'type' => 'DATE',
				'null' => true
			),
			'avatar' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => '',
			),
			'civil_status' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'default' => '',
			),
			'nationality' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'default' => ''
			),
			'country_dominicile' => array(
				'type' => 'VARCHAR',
				'constraint' => 3,
				'default' => 'PH'
			),
			'etnic_origin' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'default' => ''
			),
			'dob' => array(
				'type' => 'DATE',
				'null' => TRUE,
			),
			'age' => array(
				'type' => 'INT',
				'constraint' => 3,
				'default' => 0
			),
			'gender' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => ''
			),
			'height' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => ''
			),
			'weight' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'default' => ''
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'default' => ''
			),
			'position' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'default' => ''
			),
		));
		
		$this->dbforge->add_key('contact_id', TRUE);
		$this->dbforge->create_table('contacts', FALSE, array('ENGINE' => 'MyISAM'));

		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'group_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'),
		));

		$this->dbforge->add_key('group_id', TRUE);
		$this->dbforge->create_table('groups');

		$this->db->insert('groups', array('group_name' => 'Administrator'));
		$this->db->insert('groups', array('group_name' => 'Manager'));
		$this->db->insert('groups', array('group_name' => 'Staff'));
		$this->db->insert('groups', array('group_name' => 'Member'));
		$this->db->insert('groups', array('group_name' => 'Guest'));

		$this->load->helper('csv');
		
		$this->db->insert_batch('contacts', csv_to_array(dirname(__FILE__).'/import_contacts.csv'));

		$this->db->insert_batch('contacts', csv_to_array(dirname(__FILE__).'/import_sample_guests.csv'));
	}
	
	public function down()
	{
		$this->dbforge->drop_table('contacts');
	}
}
