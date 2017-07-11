<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_booking_events_notes extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('booking_events', array(
			'personalized' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
		));

	}

	public function down()
	{

	}
}
