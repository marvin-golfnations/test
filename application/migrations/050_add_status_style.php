<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_status_style extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('statuses', array(
			'status_style' => array(
				'type' => 'TEXT',
				'default' => ''),
		));

	}

	public function down()
	{

	}
}
