<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWeeklyintensities extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$this->forge->addField([
            'weekint_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'weekint_ward' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
			],
            'weekint_week' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
			],
            'weekint_month' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
			],
            'weekint_mm' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
			],
            'weekint_classifier' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
			],
			'last_created DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('weekint_id', true);
        $this->forge->addForeignKey('weekint_ward', 'wards', 'ward_id', 'cascade');
        $this->forge->addForeignKey('weekint_week', 'weeks', 'week_id', 'cascade');
        $this->forge->addForeignKey('weekint_month', 'months', 'month_id', 'cascade');
        $this->forge->addForeignKey('weekint_classifier', 'classifiers', 'c_id', 'cascade');
        $this->forge->createTable('weeklyintensities',true);
        $this->db->enableForeignKeyChecks();
	}
	
	public function down()
	{
		$this->forge->dropTable('weeklyintensities');
	}
}