<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Districts extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks(); // sinnce it includes foreign keys
        $this->forge->addField([
            'district_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'district_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'district_slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'district_region' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('district_id', true);
        $this->forge->addForeignKey('district_region', 'regions', 'region_id', 'cascade');
        $this->forge->createTable('districts',true);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('districts');
	}
}