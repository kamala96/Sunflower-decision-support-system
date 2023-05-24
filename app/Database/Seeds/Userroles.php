<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Userroles extends Seeder
{
	public function run()
	{
		$userroles_data = [
			[
				'role' => 'super',
				'role_description' => 'This is a top level system administrator.'
			],
			[
				'role' => 'normal',
				'role_description' => 'This is a normal system administrator, usually an agricultural extension officer.'
			],
			[
				'role' => 'farmer'
			]
		];

		foreach($userroles_data as $data){
			// insert semua data ke tabel
			$this->db->table('user_roles')->insert($data);
		}
	}
}
