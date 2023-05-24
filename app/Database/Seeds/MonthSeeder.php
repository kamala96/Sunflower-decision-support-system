<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MonthSeeder extends Seeder
{
	public function run()
	{
		$seedData = [
			[
				'month_int' => 9,
				'month_name' => 'September'
			],
			[
				'month_int' => 10,
				'month_name' => 'October'
			],
			[
				'month_int' => 11,
				'month_name' => 'November',
			],
			[
				'month_int' => 12,
				'month_name' => 'December',
			],
			[
				'month_int' => 1,
				'month_name' => 'January',
			],
			[
				'month_int' => 2,
				'month_name' => 'February',
			],
			[
				'month_int' => 3,
				'month_name' => 'March',
			],
			[
				'month_int' => 4,
				'month_name' => 'April',
			],
			[
				'month_int' => 5,
				'month_name' => 'May',
			],
			[
				'month_int' => 6,
				'month_name' => 'June',
			],
			[
				'month_int' => 7,
				'month_name' => 'July',
			],
			[
				'month_int' => 8,
				'month_name' => 'August',
			],
		];

		foreach($seedData as $data){
			// insert semua data ke tabel
			$this->db->table('months')->insert($data);
		}
	}
}
