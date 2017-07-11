<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Messages extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'message_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'message' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'sender' => array(
				'type' => 'INT',
				'constraint' => 5),
			'receiver' => array(
				'type' => 'INT',
				'constraint' => 5),
			'date_sent' => array(
				'type' => 'DATETIME'),
			'date_read' => array(
				'type' => 'DATETIME',
				'nullable' => TRUE),
			'message_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 16),
			'received' => array(
				'type' => 'SMALLINT',
				'constraint' => 1,	
				'default' => 0
			)
		));

		$this->dbforge->add_key('message_id', TRUE);
		$this->dbforge->create_table('messages');

	}
	
	public function down()
	{
		$this->dbforge->drop_table('messages');
	}
}
