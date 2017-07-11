<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_group_can_edit_completed_forms extends CI_Migration {

    public function up()
    {
        $fields = array(
            'can_edit_completed_forms' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
        );

        $this->dbforge->add_column('groups', $fields);
    }

    public function down()
    {
    }
}