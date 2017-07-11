<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Locations extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'location_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'location' => array(
				'type' => 'VARCHAR',
				'constraint' => '255')));

		$this->dbforge->add_key('location_id', TRUE);
		$this->dbforge->create_table('locations');

		$this->load->helper('csv');

		$this->db->insert_batch('locations', csv_to_array(dirname(__FILE__).'/import_locations.csv'));

	}
	
	public function down()
	{
		$this->dbforge->drop_table('locations');
	}
}
