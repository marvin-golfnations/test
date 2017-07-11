<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_booking_event_users extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'event_id' => array(
                'type' => 'INT',
                'constraint' => 5),
            'staff_id' => array(
                'type' => 'INT',
                'constraint' => 5),
        ));

        $this->dbforge->add_key('event_id', TRUE);
        $this->dbforge->add_key('staff_id', TRUE);
        $this->dbforge->create_table('booking_event_users');

        $query = $this->db->get_where('booking_events', 'assigned_to > 0');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $this->db->insert('booking_event_users', array(
                    'event_id' => $row['event_id'],
                    'staff_id' => $row['assigned_to']
                    ));
            }
        }

        $this->dbforge->drop_column('booking_events', 'assigned_to');
    }

    public function down()
    {
    }
}