<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Booking_Forms extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'booking_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'form_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'required' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'n'),
			'submitted' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'n'),
			'notify_user_on_submit' => array(
				'type' => 'VARCHAR',
				'constraint' => 255),
			'readonly_on_submit' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'n'),
			'hide_on_submit' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'n'),
			));

		$this->dbforge->add_key('booking_id', TRUE);
		$this->dbforge->add_key('form_id', TRUE);
		$this->dbforge->create_table('booking_forms');
	}
	
	public function down()
	{
		$this->dbforge->drop_table('booking_forms');
	}
}
