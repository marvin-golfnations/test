<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_work_plan extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'contact_id' => array(
                'type' => 'INT',
                'constraint' => 5),
            'date' => array(
                'type' => 'Date'),
            'work_code' => array(
	          	'type' => 'VARCHAR',
	          	'constraint' => 16  
            ),
        ));

        $this->dbforge->create_table('user_work_plan_day');

        $query = $this->db->get_where('users', 'work_plan_code IS NOT NULL');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
	            
	            $days = unserialize($row['work_plan_code']);
	            
	            foreach ($days as $day => $code) {
		            $this->db->insert('user_work_plan_day', array('contact_id' => $row['contact_id'], 'date' => $day, 'work_code' => $code));
	            }
            }
        }

        return false;
    }

    public function down()
    {
	    $this->dbforge->drop_table('user_work_plan');
    }
}