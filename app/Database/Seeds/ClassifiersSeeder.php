<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClassifiersSeeder extends Seeder
{
	public function run()
	{
		$classifier_data = [
			['c_min' => 0, 'c_max' => 10, 'c_desc' => 'Sunny', 'c_img' => 'sunny.gif'],
			['c_min' => 11, 'c_max' => 50, 'c_desc' => 'Cloudy', 'c_img' => 'cloudy.gif'],
			['c_min' => 51, 'c_max' => 100, 'c_desc' => 'Light Rain', 'c_img' => 'light_rain.gif'],
			['c_min' => 101, 'c_max' => 500, 'c_desc' => 'Moderate Rain', 'c_img' => 'moderate_rain.gif'],
			['c_min' => 501, 'c_max' => 1000, 'c_desc' => 'Heavy Rain', 'c_img' => 'heavy_rain.gif'],
		];

		foreach($classifier_data as $data)
		{
			$this->db->table('classifiers')->insert($data);
		}
	}
}
