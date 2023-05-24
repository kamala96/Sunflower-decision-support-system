<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Users extends Seeder
{
	public function run()
	{
		$this->db->table('users')->insert([
			'first_name' => 'Basilei', 'last_name' => 'Mkude',
			'email' => 'basilei.mkude@gmail.com', 'phone' => '+255713678534',
			'password' => password_hash('basilei', PASSWORD_DEFAULT),
			'role_id' => 1, 'username' => 'basilei']);
			for ($i = 0; $i < 4; $i++) { 
				//to add 10 users. Change limit as desired
				$this->db->table('users')->insert($this->generateUsers());
			}
		}
		
		private function generateUsers(): array
		{
			$faker = Factory::create();
			return [
				'first_name' => $faker->firstName(),
				'last_name' => $faker->lastName(),
				'email' => $faker->email,
				'phone' => $faker->e164PhoneNumber(),
				'password' => password_hash('123456', PASSWORD_DEFAULT),
				'role_id' => $faker->randomElement([2, 3]),
				'username' => $faker->userName().$faker->randomNumber(3, true),
				'ward' => $faker->randomElement([2, 5, 6, 10, 15, 20, 22])
			];
		}
	}