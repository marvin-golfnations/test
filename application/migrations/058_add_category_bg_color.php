<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_category_bg_color extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('categories', array(
            'cat_bg_color' => array(
                'type' => 'VARCHAR',
                'constraint' => 1,
                'default' => ''),
        ));
    }

    public function down()
    {
    }
}