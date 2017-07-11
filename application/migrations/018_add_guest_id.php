<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Guest_id extends CI_Migration {

    public function up()
    {
        $fields = array(
            'guest_id' => array('type' => 'INT', 'constraint' => 11)
        );
        $this->dbforge->add_column('bookings', $fields);

        $this->dbforge->drop_table('booking_users');
    }

    public function down()
    {
    }
}