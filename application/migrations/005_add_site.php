<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Site extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'site_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE),
			'site_title' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'),
			'site_system_preferences' => array(
				'type' => 'TEXT'),
			));

		$this->dbforge->add_key('site_id', TRUE);
		$this->dbforge->create_table('sites');

		$this->db->insert('sites', array(
			'site_title' => 'The Farm at San Benito',
			'site_system_preferences' => json_encode(array(
				'localization' => array(
					'timezone' => 'GMT+8',
					'date_format' => 'mm/dd/YYYY',
					'language' => 'en'
				),
				'upload_path' => '',
			))
		));
	}
	
	public function down()
	{
		$this->dbforge->drop_table('sites');
	}
}
