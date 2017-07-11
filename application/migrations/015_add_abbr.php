<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Abbr extends CI_Migration {

	public function up()
	{
		$fields = array(
			'abbr' => array('type' => 'VARCHAR', 'constraint' => 16)
		);
		$this->dbforge->add_column('items', $fields);
		$this->dbforge->add_column('facilities', $fields);
	}
	
	public function down()
	{
	}
}
