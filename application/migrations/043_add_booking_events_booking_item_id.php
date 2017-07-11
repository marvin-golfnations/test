<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_booking_events_booking_item_id extends CI_Migration {

    public function up()
    {
        $fields = array(
            'booking_item_id' => array('type' => 'INT', 'constraint' => 5, 'default' => 0),
        );

        $this->dbforge->add_column('booking_events', $fields);

        $this->dbforge->drop_column('booking_events', 'item_id');
        $this->dbforge->drop_column('booking_events', 'booking_id');
    }

    public function down()
    {
    }
}