<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_group_can_assign_schedules extends CI_Migration {

    public function up()
    {
        $fields = array(
            'can_assign_schedules' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
        );

        $this->dbforge->add_column('groups', $fields);
    }

    public function down()
    {
    }
}