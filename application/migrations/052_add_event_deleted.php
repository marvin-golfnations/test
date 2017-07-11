<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_event_deleted extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('booking_events', array(
			'deleted' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'n'),
			'deleted_date' => array(
				'type' => 'INT',
				'constraint' => 10,
				'default' => 0),
			'deleted_by' => array(
				'type' => 'INT',
				'constraint' => 5,
				'default' => 0),		
		));

	}

	public function down()
	{

	}
}
