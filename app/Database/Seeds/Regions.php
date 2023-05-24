<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Regions extends Seeder
{
	public function run()
	{
		$regions_data = [
			[
				'region_name' => 'Singida',
				'region_slug' => 'singida'
			],
		];

		foreach($regions_data as $data){
			// insert semua data ke tabel
			$this->db->table('regions')->insert($data);
		}
	}
}
