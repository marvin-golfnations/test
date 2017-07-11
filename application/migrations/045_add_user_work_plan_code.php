<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_work_plan_code extends CI_Migration {

    public function up()
    {
        $fields = array(
            'work_plan_code' => array('type' => 'TEXT', 'default' => ''),
        );

        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
    }
}