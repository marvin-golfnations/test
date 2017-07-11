<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Upload_Prefs extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'upload_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'max_size' => array(
				'type' => 'INT',
				'constraint' => 11),
			'max_height' => array(
				'type' => 'INT',
				'constraint' => 11),
			'max_width' => array(
				'type' => 'INT',
				'constraint' => 11),
			'upload_path' => array(
				'type' => 'VARCHAR',
				'constraint' => 255),
			'allowed_types' => array(
				'type' => 'VARCHAR',
				'constraint' => 100),
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => 255),
			'location_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE)
			));

		$this->dbforge->add_key('upload_id', TRUE);
		$this->dbforge->create_table('upload_prefs');

		$this->db->insert('upload_prefs', array(
			'name' => 'Default File Upload Directory',
			'max_size' => 0,
			'max_height' => 0,
			'max_width' => 0,
			'allowed_types' => 'pdf|docx|doc|png|jpg|doc',
			'upload_path' => dirname(SELF).'/uploads/',
			'url' => '/uploads/',
			'location_id' => 0
		));
	}
	
	public function down()
	{
		$this->dbforge->drop_table('upload_prefs');
	}
}
