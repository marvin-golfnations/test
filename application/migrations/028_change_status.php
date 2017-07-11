<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_Status extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('bookings', array(
			'status' => array(
				'name' => 'status',
				'type' => 'VARCHAR',
				'constraint' => 16
			)));

		$this->dbforge->modify_column('booking_events', array(
			'status' => array(
				'name' => 'status',
				'type' => 'VARCHAR',
				'constraint' => 16
			)));

		$this->db->update('booking_events', array('status' => 'confirmed'), 'status="2"');
		$this->db->update('bookings', array('status' => 'confirmed'), 'status="2"');
	}

	public function down()
	{

	}
}