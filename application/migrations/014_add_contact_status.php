<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Contact_Status extends CI_Migration {

	public function up()
	{
		$fields = array(
			'deleted' => array('type' => 'SMALLINT', 'constraint' => 1, 'default' => 0)
		);
		$this->dbforge->add_column('contacts', $fields);
	}
	
	public function down()
	{
	}
}
