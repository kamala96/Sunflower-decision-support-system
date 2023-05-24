<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Districts extends Seeder
{
	public function run()
	{
		$districts_data = [
			['district_name' => 'Iramba', 'district_slug' => 'iramba', 'district_region' => 1],
			['district_name' => 'Manyoni', 'district_slug' => 'manyoni', 'district_region' => 1],
			['district_name' => 'Singida Vijijini', 'district_slug' => 'singida-vj', 'district_region' => 1],
			['district_name' => 'Singida Mjini', 'district_slug' => 'singida-mj', 'district_region' => 1],
			['district_name' => 'Ikungi', 'district_slug' => 'ikungi', 'district_region' => 1],
			['district_name' => 'Mkalama', 'district_slug' => 'mkalama', 'district_region' => 1],
		];

		foreach($districts_data as $data){
			// insert semua data ke tabel
			$this->db->table('districts')->insert($data);
		}
	}
}
