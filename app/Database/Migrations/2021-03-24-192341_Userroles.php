<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Userroles extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'role_description' => [
                'type' => 'TEXT',
                'null' => true
            ],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('role_id', true);
        $this->forge->createTable('user_roles',true);
	}

	public function down()
	{
		$this->forge->dropTable('user_roles');
	}
}
