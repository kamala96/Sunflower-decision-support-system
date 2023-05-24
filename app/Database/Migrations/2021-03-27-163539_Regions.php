<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Regions extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'region_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'region_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'region_slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);
        $this->forge->addKey('region_id', true);
        $this->forge->createTable('regions',true);
	}

	public function down()
	{
		$this->forge->dropTable('regions');
	}
}
