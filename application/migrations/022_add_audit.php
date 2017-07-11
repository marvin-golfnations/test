<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Audit extends CI_Migration {

    public function up()
    {
        $fields = array(
            'author_id' => array('type' => 'INT', 'constraint' => 5, 'default' => 1),
            'entry_date' => array('type' => 'INT', 'constraint' => 10, 'default' => 0),
            'edit_date' => array('type' => 'INT', 'constraint' => 10, 'default' => 0),
        );

        $this->dbforge->add_column('bookings', $fields);
        $this->dbforge->add_column('booking_events', $fields);
    }

    public function down()
    {
    }
}