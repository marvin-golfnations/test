<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Facility_Status extends CI_Migration {

	public function up()
	{
		$fields = array(
			'status' => array('type' => 'SMALLINT', 'constraint' => 1, 'default' => 1)
		);
		$this->dbforge->add_column('facilities', $fields);
	}
	
	public function down()
	{
	}
}
