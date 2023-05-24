<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassifier extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'c_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'c_min' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'c_max' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'c_desc' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'c_img' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
        ]);
        $this->forge->addKey('c_id', true);
        $this->forge->createTable('classifiers',true);
	}

	public function down()
	{
		$this->forge->dropTable('classifiers');
	}
}
