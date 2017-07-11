<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_booking_events_cancelled extends CI_Migration {

    public function up()
    {
        $fields = array(
            'called_by' => array('type' => 'INT', 'constraint' => 5, 'default' => 0),
            'cancelled_by' => array('type' => 'INT', 'constraint' => 5, 'default' => 0),
            'cancelled_reason' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
            'date_cancelled' => array('type' => 'INT', 'constraint' => 10, 'default' => 0),
        );

        $this->dbforge->add_column('booking_events', $fields);
    }

    public function down()
    {
    }
}