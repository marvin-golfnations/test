<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Facilities extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'facility_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'facility_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'bg_color' => array(
				'type' => 'VARCHAR',
				'constraint' => '7'),
			'max_accomodation' => array(
				'type' => 'INT',
				'constraint' => 5,
			),
			'location_id' => array(
				'type' => 'INT',
				'constraint' => 5,
			),
			'parent' => array(
				'type' => 'INT',
				'constraint' => 5,
			)));

		$this->dbforge->add_key('facility_id', TRUE);
		$this->dbforge->create_table('facilities');

		$this->load->helper('csv');

		$this->db->insert_batch('facilities', csv_to_array(dirname(__FILE__).'/import_facilities.csv'));


	}
	
	public function down()
	{
		$this->dbforge->drop_table('facilities');
	}
}
