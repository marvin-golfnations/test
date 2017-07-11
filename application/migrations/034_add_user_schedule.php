<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_schedule extends CI_Migration {

    public function up()
    {
        $fields = array(
            'weekly_schedule' => array('type' => 'TEXT'),
            'special_schedule' => array('type' => 'TEXT'),
        );

        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
    }
}