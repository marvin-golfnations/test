<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Upgrade extends CI_Migration {

    public function up()
    {
        $fields = array(
            'upgrade' => array('type' => 'SMALLINT', 'constraint' => 1, 'default' => 0)
        );
        $this->dbforge->add_column('booking_items', $fields);
    }

    public function down()
    {
    }
}