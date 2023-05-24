<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Seed extends BaseController
{
	public function index()
	{
		$seeder = \Config\Database::seeder();

		try
		{
			$seeder->call('ClassifiersSeeder');
			$seeder->call('Regions');
			$seeder->call('Districts');
			$seeder->call('Wards');
			$seeder->call('Userroles');
			$seeder->call('Users');
			$seeder->call('MonthSeeder');
			$seeder->call('WeekSeeder');
			echo 1;
		}
		catch (\Throwable $e)
		{
			// Do something with the error here...
			echo "<pre>";
			print_r($e);
			echo "</pre>";
		}
	}
}
