<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_form_fields extends CI_Migration {

	public function up()
	{
        $this->dbforge->rename_table('form_fields', 'fields');

        $this->dbforge->add_field(array(
            'field_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE),
            'form_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE),
            'guest_only' => array(
                'type' => 'CHAR',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->add_key('field_id', TRUE);
        $this->dbforge->add_key('form_id', TRUE);
        $this->dbforge->create_table('form_fields');

        $query = $this->db->get('forms');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $this->dbforge->add_column('form_entries_'.$row['form_id'], array(
                    'completed_by' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                    )
                ));

                $this->dbforge->add_column('form_entries_'.$row['form_id'], array(
                    'completed_date' => array(
                        'type' => 'INT',
                        'constraint' => 10,
                        'unsigned' => TRUE,
                    )
                ));

                if ($row['field_ids']) {

                    $field_data = array();
                    $fields = explode('|', $row['field_ids']);
                    foreach ($fields as $field) {
                        $field_data[] = array(
                            'form_id' => $row['form_id'],
                            'field_id' => $field,
                            );
                    }
                    $this->db->insert_batch('form_fields', $field_data);
                }
            }
        }

        $this->dbforge->add_column('files', array(
            'last_viewed' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            )
        ));

        $this->dbforge->add_column('files', array(
            'viewed_by' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            )
        ));
	}

	public function down()
	{
        $this->dbforge->drop_table('form_fields');
	}
}
