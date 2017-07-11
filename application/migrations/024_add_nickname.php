<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Nickname extends CI_Migration {

    public function up()
    {
        $fields = array(
            'nickname' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => ''),
        );

        $this->dbforge->add_column('contacts', $fields);
    }

    public function down()
    {
    }
}