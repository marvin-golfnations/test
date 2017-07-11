<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_work_plan_code extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'work_plan_cd' => array(
                'type' => 'VARCHAR',
                'constraint' => 32),
            'work_plan_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100),
        ));
		
		$this->dbforge->add_key('work_plan_cd', TRUE);
        $this->dbforge->create_table('user_work_plan_code');

        $codes = get_schedule_codes();
        
        foreach ($codes as $cd => $name) {
	        $this->db->insert('user_work_plan_code', array('work_plan_cd' => $cd, 'work_plan_name' => $name));
        }
    }

    public function down()
    {
	    $this->dbforge->drop_table('user_work_plan_code');
    }
}