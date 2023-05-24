<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivity extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$this->forge->addField([
            'act_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'act_week' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'act_month' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'act_desc' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'act_requirement' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('act_id', true);
        $this->forge->addForeignKey('act_week', 'weeks', 'week_id', 'cascade');
        $this->forge->addForeignKey('act_month', 'months', 'month_id', 'cascade');
        // $this->forge->addForeignKey('act_requirement', 'classifiers', 'c_id', 'cascade');
        $this->forge->createTable('activities',true);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('activities');
	}
}
