<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Group_Fields extends CI_Migration {

    public function up()
    {
        $fields = array(
            'include_in_provider_list' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'include_in_audit_list' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_view_other_profiles' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_delete_services' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_edit_services' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_admin_guest' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_admin_calendar' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_admin_providers' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_admin_services' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_admin_facilities' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'can_admin_packages' => array('type' => 'VARCHAR', 'constraint' => 1, 'default' => 'n'),
            'location' => array('type' => 'VARCHAR', 'constraint' => 16, 'default' => ''),
        );

        $this->dbforge->add_column('groups', $fields);
    }

    public function down()
    {
    }
}