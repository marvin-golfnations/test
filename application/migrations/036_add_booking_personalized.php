<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_booking_personalized extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('bookings', array(
			'personalized' => array(
				'type' => 'SMALLINT',
				'constraint' => 1,
				'default' => 0),
		));

	}

	public function down()
	{

	}
}
