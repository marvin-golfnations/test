<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Event_Notes extends CI_Migration {

    public function up()
    {
        $fields = array(
            'notes' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
        );

        $this->dbforge->add_column('booking_events', $fields);
    }

    public function down()
    {
    }
}