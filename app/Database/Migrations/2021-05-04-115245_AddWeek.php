<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWeek extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'week_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'week_int' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'week_description' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
        ]);
        $this->forge->addKey('week_id', true);
        $this->forge->createTable('weeks',true);
	}

	public function down()
	{
		$this->forge->dropTable('weeks');
	}
}
