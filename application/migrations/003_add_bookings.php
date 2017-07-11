<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Bookings extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'booking_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'package_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'nullable' => true
			),
			'start_date' => array(
				'type' => 'INT',
				'nullable' => TRUE),
			'end_date' => array(
				'type' => 'INT',
				'nullable' => TRUE),
			'notes' => array(
				'type' => 'TEXT'
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1)));
		
		$this->dbforge->add_key('booking_id', TRUE);
		$this->dbforge->create_table('bookings');
		
		$this->dbforge->add_field(array(
			'booking_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'guest_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE)));
		$this->dbforge->add_key('booking_id', TRUE);
		$this->dbforge->add_key('guest_id', TRUE);
		$this->dbforge->create_table('booking_users');

		$this->dbforge->add_field(array(
			'event_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'event_title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'booking_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE),
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE),
			'assigned_to' => array(
				'type' => 'INT',
				'constraint' => 5,
				'nullable' => TRUE),
			'start_dt' => array(
				'type' => 'DATETIME',
				'nullable' => TRUE),
			'end_dt' => array(
				'type' => 'DATETIME',
				'nullable' => TRUE
			),
			'facility_id' => array(
				'type' => 'INT',
				'constraint' => 5,
			),
			'all_day' => array(
				'type' => 'INT',
				'constraint' => 1
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 2
			)));
		$this->dbforge->add_key('event_id', TRUE);
		$this->dbforge->add_key('booking_id', TRUE);
		$this->dbforge->create_table('booking_events');


		$this->dbforge->add_field(array(
			'booking_item_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'booking_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE),
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE),
			'quantity' => array(
				'type' => 'INT',
				'constraint' => 5
			),
			'included' => array(
				'type' => 'INT',
				'constraint' => 1
			),
			'foc' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 0,
			),
			'upsell' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 0
			)));
		$this->dbforge->add_key('booking_item_id', TRUE);
		$this->dbforge->create_table('booking_items');
		
	}
	
	public function down()
	{
		$this->dbforge->drop_table('booking_events');
		$this->dbforge->drop_table('booking_users');
		$this->dbforge->drop_table('booking_items');
		$this->dbforge->drop_table('bookings');
	}
}
