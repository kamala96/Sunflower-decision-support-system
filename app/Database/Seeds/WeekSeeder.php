<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WeekSeeder extends Seeder
{
	public function run()
	{
		$seedData = [
			[
				'week_int' => 2,
				'week_description' => 'Second Week'
			],
			[
				'week_int' => 1,
				'week_description' => 'First Week'
			],
			[
				'week_int' => 4,
				'week_description' => 'Fourth Week',
			],
			[
				'week_int' => 3,
				'week_description' => 'Third Week',
			],
		];

		foreach($seedData as $data){
			// insert semua data ke tabel
			$this->db->table('weeks')->insert($data);
		}
	}
}
