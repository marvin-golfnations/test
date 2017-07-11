<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Related_facilities extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				),
			'facility_id' => array(
				'type' => 'INT',
				'constraint' => 5),
		));
		$this->dbforge->add_key('item_id', TRUE);
		$this->dbforge->add_key('facility_id', TRUE);
		$this->dbforge->create_table('items_related_facilities');
	}
	
	public function down()
	{
		$this->dbforge->drop_table('items_related_facilities');
	}
}
