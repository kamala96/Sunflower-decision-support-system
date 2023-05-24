<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddViswaswadu extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks(); // sinnce it includes foreign keys
        $this->forge->addField([
            'v_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'v_phone' => [
                'type' => 'INT',
                'constraint' => 9,
                'unsigned' => true,
                'unique' => true,
            ],
            'v_ward' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('v_id', true);
        $this->forge->addForeignKey('v_ward', 'wards', 'ward_id', 'cascade');
        $this->forge->createTable('viswaswadu', true);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('viswaswadu');
	}
}
