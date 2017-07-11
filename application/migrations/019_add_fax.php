<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Fax extends CI_Migration {

    public function up()
    {
        $fields = array(
            'fax' => array('type' => 'SMALLINT', 'constraint' => 3, 'default' => 0)
        );
        $this->dbforge->add_column('bookings', $fields);
    }

    public function down()
    {
    }
}