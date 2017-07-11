<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Related_Forms extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'form_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'auto_increment' => TRUE),
			'item_id' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			));

		$this->dbforge->add_key('form_id', TRUE);
		$this->dbforge->add_key('item_id', TRUE);
		$this->dbforge->create_table('items_related_forms');
		
	}
	
	public function down()
	{
		$this->dbforge->drop_table('items_related_forms');
	}
}
