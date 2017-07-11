<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_form_completed_by extends CI_Migration {

	public function up()
	{

        $this->dbforge->add_column('booking_forms', array(
            'completed_by' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'default' => 0
            )
        ));

        $this->dbforge->add_column('booking_forms', array(
            'completed_date' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            )
        ));

	}
	public function down()
	{
	}
}
