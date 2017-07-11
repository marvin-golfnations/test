<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Event_called_by extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('booking_events', array(
			'called_by' => array(
				'type' => 'INT',
				'constraint' => 5,
				'default' => 0),
		));

	}

	public function down()
	{

	}
}
