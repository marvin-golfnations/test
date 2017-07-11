<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Item_max_provider extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('items', array(
			'max_provider' => array(
				'type' => 'INT',
				'constraint' => 3,
				'default' => 1),
		));

	}

	public function down()
	{

	}
}
