<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_calendar_show_no_schedule extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('users', array(
			'calendar_show_no_schedule' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'y'),
		));

	}

	public function down()
	{

	}
}
