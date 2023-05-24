<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use Faker\Factory;
use App\Models\WardsModel;
use App\Models\WeekModel;
use App\Models\MonthModel;
use App\Models\WeeklyintensityModel;
use App\Models\ClassifierModel;

class WeatherCron extends BaseController
{
	public function index()
	{
		// $myTime = Time::today();
		$startingDate = new Time('now');
		$startingMonth = $startingDate->toLocalizedString('M');
		$startingYear = $startingDate->toLocalizedString('yyyy');
		
		$endingDate = new Time('+2 month');
		$endingYear = $endingDate->toLocalizedString('yyyy');
		$endingMonth = $endingDate->toLocalizedString('M');
		
		$model1 = new WardsModel();
		$model2 = new WeekModel();
		$model3 = new MonthModel();
		$model4 = new WeeklyintensityModel();
		$model5 = new ClassifierModel();
		$wards = $model1->findAll();
		if(!empty($wards))
		{
			$cronData = [];
			$weeks = $model2->getWeeks();
			$months = $model3->getMonths($startingMonth, $endingMonth);
			$classifiers = $model5->orderBy('c_min', 'ASC')->findAll();
			foreach($wards as $ward)
			{
				$lon = $ward['ward_longtude'];
				$lat = $ward['ward_longtude'];
				foreach ($months as $month)
				{
					foreach ($weeks as $week)
					{
						$classifierID = NULL;
						$result = $this->weatherFaker($week['week_id'], $month['month_id'], $lon, $lat);
						$i = 0;
						$len = count($classifiers);
						foreach ($classifiers as $row)
						{
							if ($i == $len - 1)
							{
								if($result >= $row['c_min'])
								{
									$classifierID = $row['c_id'];
									break;
								}
							}
							else 
							{
								if($result >= $row['c_min'] && $result <= $row['c_max'])
								{
									$classifierID = $row['c_id'];
									break;
								}
							}
							$i++;
						}
						$cronData[] = [
							'weekint_ward' => $ward['ward_id'],
							'weekint_week' => $week['week_id'],
							'weekint_month' => $month['month_id'],
							'weekint_mm' => $result,
							'weekint_classifier' => $classifierID,
						];
					}
				}
			}
			if(! empty($cronData))
			{
				try
				{
					// Delete || truncate table first;
					$model4->truncate();
					
					// $model4->insertBatch($cronData, null, 496);
					$model4->insertBatch($cronData);
					echo json_encode(array("status" => true , 'data' => 'Success Cron'));
					echo '<pre><code>';
					print_r($cronData);
				}
				catch (\Throwable $e)
				{
					echo json_encode(array("status" => false , 'data' => 'Error'));
					echo '<pre>';
					print_r($e);
					echo '<br />';
					echo '<code>';
					print_r($cronData);
				}
			}
			else
			{
				echo json_encode(array("status" => false, "data" => "No data to insert"));
			}
		}
		else
		{
			echo json_encode(array("status" => false, "data" => "No wards"));
		}
	}
	
	
	public function index2()
	{
		// $myTime = Time::today();
		$startingDate = new Time('now');
		$startingMonth = $startingDate->toLocalizedString('M');
		$startingYear = $startingDate->toLocalizedString('yyyy');
		
		$endingDate = new Time('+2 month');
		$endingYear = $endingDate->toLocalizedString('yyyy');
		$endingMonth = $endingDate->toLocalizedString('M');
		
		$model1 = new WardsModel();
		$model2 = new WeekModel();
		$model3 = new MonthModel();
		$model4 = new WeeklyintensityModel();
		$model5 = new ClassifierModel();
		$wards = $model1->findAll();
		if(!empty($wards))
		{
			$cronData = [];
			$weeks = $model2->getWeeks();
			$months = $model3->getMonths($startingMonth, $endingMonth);
			$classifiers = $model5->orderBy('c_min', 'ASC')->findAll();
			foreach($wards as $ward)
			{
				$lon = $ward['ward_longtude'];
				$lat = $ward['ward_longtude'];
				foreach ($months as $month)
				{
					foreach ($weeks as $week)
					{
						$classifierID = NULL;
						$result = $this->weatherFaker($week['week_id'], $month['month_id'], $lon, $lat);
						$i = 0;
						$len = count($classifiers);
						foreach ($classifiers as $row)
						{
							if ($i == $len - 1)
							{
								if($result >= $row['c_min'])
								{
									$classifierID = $row['c_id'];
									break;
								}
							}
							else 
							{
								if($result >= $row['c_min'] && $result <= $row['c_max'])
								{
									$classifierID = $row['c_id'];
									break;
								}
							}
							$i++;
						}
						$cronData[] = [
							'weekint_ward' => $ward['ward_id'],
							'weekint_week' => $week['week_id'],
							'weekint_month' => $month['month_id'],
							'weekint_mm' => $result,
							'weekint_classifier' => $classifierID,
						];
					}
				}
			}
			if(! empty($cronData))
			{
				try
				{
					// Delete || truncate table first;
					$model4->truncate();
					
					// $model4->insertBatch($cronData, null, 496);
					$model4->insertBatch($cronData);
					echo json_encode(array("status" => true , 'data' => 'Success Cron'));
					echo '<pre>';
					print_r($cronData);
					echo '</pre>';
				}
				catch (\Throwable $e)
				{
					echo json_encode(array("status" => false , 'data' => 'Error'));
					echo '<pre>';
					print_r($e);
					echo '<br />';
					echo '<code>';
					print_r($cronData);
				}
			}
			else
			{
				echo json_encode(array("status" => false, "data" => "No data to insert"));
			}
		}
		else
		{
			echo json_encode(array("status" => false, "data" => "No wards"));
		}
	}
	
	protected function weatherFaker($week, $month, $lon, $lat)
	{
		$faker = Factory::create();
		return $faker->randomElement([2, 500, 6000, 150, 1500, 200, 212, 2, 500, 6000, 
		150, 1500, 200, 212, 300, 888, 38, 400, 48, 98, 0, 250, 999, 100, 45, 89, 700, 23, 479,
		1002, 34, 568, 555, 374, 21, 111, 49, 456, 33, 98, 102, 560, 90]);
	}
}