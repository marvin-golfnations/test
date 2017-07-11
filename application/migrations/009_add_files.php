<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Files extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'file_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'file_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'file_size' => array(
				'type' => 'INT',
				'constraint' => '11'),
			'upload_id' => array(
				'type' => 'INT',
				'constraint' => 5,
			),
			'upload_date' => array(
				'type' =>'INT',
				'constraint' => 10,
			),	
			'location_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE)
			));

		$this->dbforge->add_key('file_id', TRUE);
		$this->dbforge->create_table('files');

		// Attachments
		$this->dbforge->add_field(array(
			'booking_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'file_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE),
			));
		$this->dbforge->add_key('booking_id', TRUE);
		$this->dbforge->add_key('file_id', TRUE);
		$this->dbforge->create_table('booking_attachments');
	}
	
	public function down()
	{
		$this->dbforge->drop_table('files');
		$this->dbforge->drop_table('booking_attachments');
	}
}
