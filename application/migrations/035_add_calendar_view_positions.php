<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Calendar_view_positions extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('users', array(
			'calendar_view_positions' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'default' => ''),
		));

	}

	public function down()
	{

	}
}
