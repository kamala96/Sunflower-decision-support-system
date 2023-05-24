<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Wards extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks(); // sinnce it includes foreign keys
        $this->forge->addField([
            'ward_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'ward_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'ward_slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'ward_district' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'ward_longtude' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'ward_latitude' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('ward_id', true);
        $this->forge->addForeignKey('ward_district', 'districts', 'district_id', 'cascade');
        $this->forge->createTable('wards',true);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('wards');
	}
}
