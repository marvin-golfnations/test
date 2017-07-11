<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Status extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'group_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
		));

		$this->dbforge->add_key('group_id', TRUE);
		$this->dbforge->create_table('status_groups');

		$this->db->insert_batch('status_groups', array(array(
			'group_name' => 'Booking Statuses'
		), array(
			'group_name' => 'Schedule Statuses'
		)));

		$this->dbforge->add_field(array(
			'status_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'status_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255),
			'status_order' => array(
				'type' => 'INT',
				'constraint' => 2)
		));

		$this->dbforge->add_key('status_id', TRUE);
		$this->dbforge->create_table('statuses');

		$this->db->insert_batch('statuses', array(
			array('group_id' => 1, 'status_name' => 'Tentative', 'status_order' => 1),
			array('group_id' => 1, 'status_name' => 'Confirmed', 'status_order' => 2),
			array('group_id' => 1, 'status_name' => 'Completed', 'status_order' => 3),
			array('group_id' => 1, 'status_name' => 'Cancelled', 'status_order' => 4),
		));

		$this->db->insert_batch('statuses', array(
			array('group_id' => 2, 'status_name' => 'Tentative', 'status_order' => 1),
			array('group_id' => 2, 'status_name' => 'Confirmed', 'status_order' => 2),
			array('group_id' => 2, 'status_name' => 'Completed', 'status_order' => 3),
			array('group_id' => 2, 'status_name' => 'Cancelled', 'status_order' => 4),
			array('group_id' => 2, 'status_name' => 'No Show', 'status_order' => 5),
			array('group_id' => 2, 'status_name' => 'On Going', 'status_order' => 6),
		));
	}

	public function down()
	{
		$this->dbforge->drop_table('status_groups');
		$this->dbforge->drop_table('statuses');
	}
}