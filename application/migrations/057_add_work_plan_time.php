<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_work_plan_time extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'contact_id' => array(
                'type' => 'INT',
                'constraint' => 5),
            'start_date' => array(
                'type' => 'DATETIME'),
            'end_date' => array(
                'type' => 'DATETIME'),    
        ));

        $this->dbforge->create_table('user_work_plan_time');

        $query = $this->db->get_where('users', 'work_plan_code IS NOT NULL');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
	            
	            $days = unserialize($row['work_plan']);
	            
	            foreach ($days as $day => $times) {
					if ($times && count($times) > 0) {
						foreach ($times as $time) {
							$start_date = new DateTime($day.' '.$time);
							$end_date = new DateTime($day.' '.$time);
							$end_date->add(new DateInterval('PT29M'));
							$this->db->insert('user_work_plan_time', 
								array(
									'contact_id' => $row['contact_id'], 
									'start_date' => $start_date->format('Y-m-d H:i:s'),
									'end_date' => $end_date->format('Y-m-d H:i:s')
									));		
						}
					}
	            }
            }
        }

        return false;
    }

    public function down()
    {
	    $this->dbforge->drop_table('user_work_plan_time');
    }
}