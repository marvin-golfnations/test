<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_pref extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('users', array(
			'preferences' => array(
				'type' => 'TEXT',
				'default' => ''),
		));

	}

	public function down()
	{

	}
}
