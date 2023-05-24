<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMonth extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'month_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'month_int' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'month_name' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
        ]);
        $this->forge->addKey('month_id', true);
        $this->forge->createTable('months',true);
	}

	public function down()
	{
		$this->forge->dropTable('months');
	}
}
