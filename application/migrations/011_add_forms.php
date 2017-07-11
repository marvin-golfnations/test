<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Forms extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'form_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'form_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'field_ids' => array(
				'type' => 'VARCHAR',
				'constraint' => 100),
			'author_id' => array(
				'type' => 'INT',
				'constraint' => 5),
			'entry_date' => array(
				'type' => 'INT',
				'constraint' => 10),
			'edit_date' => array(
				'type' => 'INT',
				'constraint' => 10)
			));

		$this->dbforge->add_key('form_id', TRUE);
		$this->dbforge->create_table('forms');

		$this->dbforge->add_field(array(
				'field_id' => array(
						'type' => 'INT',
						'constraint' => 5,
						'unsigned' => TRUE,
						'auto_increment' => TRUE),
				'field_name' => array(
						'type' => 'VARCHAR',
						'constraint' => 100),
				'field_label' => array(
						'type' => 'VARCHAR',
						'constraint' => 255),
				'field_type' => array(
						'type' => 'VARCHAR',
						'constraint' => 32),
				'settings' => array(
						'type' => 'TEXT'),
				'required' => array(
						'type' => 'CHAR',
						'constraint' => 1),
				'entry_date' => array(
						'type' => 'INT',
						'constraint' => 10),
				'edit_date' => array(
						'type' => 'INT',
						'constraint' => 10)
		));
		
		$this->dbforge->add_key('field_id', TRUE);
		$this->dbforge->create_table('form_fields');
		
		
	}
	
	public function down()
	{
		$this->dbforge->drop_table('forms');
		$this->dbforge->drop_table('form_fields');
	}
}
