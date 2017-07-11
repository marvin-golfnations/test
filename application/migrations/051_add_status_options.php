<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_status_options extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('statuses', array(
			'include_in_sales' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'y'),
			'include_in_duplicate_checking' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'y'),
		));

	}

	public function down()
	{

	}
}
