<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Secretary extends CI_Migration {

    public function up()
    {
        $query = $this->db->get_where('groups', 'group_name="Secretary"');
        if ($query->num_rows() === 0)
            $this->db->insert('groups', array('group_name' => 'Secretary'));
    }

    public function down()
    {
    }
}