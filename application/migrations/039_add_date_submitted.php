<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_date_submitted extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('booking_forms', array(
			'submitted_date' => array(
				'type' => 'INT',
				'constraint' => 10 ,
				'default' => 0),
		));

	}

	public function down()
	{

	}
}
