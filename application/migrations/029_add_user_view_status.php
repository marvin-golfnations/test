<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_User_View_Status extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('users', array(
			'calendar_view_status' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'default' => ''),
		));

	}

	public function down()
	{

	}
}
