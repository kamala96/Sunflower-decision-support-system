<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Exception;
use \Firebase\JWT\JWT;

use CodeIgniter\I18n\Time;

use App\Models\WardsModel;
use App\Models\WeeklyintensityModel;
use App\Models\ActivityModel;
use App\Models\WeekModel;

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control");

class ApiController extends ResourceController
{
	protected function getActivity($classifier, $week, $month)
	{
		$model = new ActivityModel();
		$value = $model->getActivity($classifier, $week, $month);
		if($value == null)
		{
			return null;
		}
		return $value['act_desc'];
	}

	public function getWards()
	{
		$model = new WardsModel();
		$wards = $model->getWards();
		if($wards == false)
		{
			$response = [
				'status' => 500,
				'error' => TRUE,
				'messages' => 'No beacons'
			];
			return $this->respond($response);
		}
		else
		{
			$response = [
				'status' => 200,
				'error' => FALSE,
				'messages' => "Wards Found",
				'data' => $wards,
			];
			return $this->respond($response);
		}
	}
	
	public function getWeather($id)
	{
		$model1 = new WeeklyintensityModel();
		$model2 = new WardsModel();
		$model3 = new WeekModel();
		
		// $currentYear = new Time('now');
        // $currentYear = $currentYear->toLocalizedString('yyyy');
        // $nextYear = new Time('+1 year');
        // $nextYear = $nextYear->toLocalizedString('yyyy');
		
		$wardsWeather = $model1->weatherDataForAPI($id);
		
		if($wardsWeather == false)
		{
			$response = [
				'status' => 500,
				'error' => TRUE,
				'messages' => 'No data'
			];
			return $this->respond($response);
		}
		else
		{
			$resultArray = [];
			foreach ($wardsWeather as $key => $value)
			{
				// $weekName = $model3->where('week_id', $value['weekint_week'])->first();
				$weekName = $model3->find($value['weekint_week']);
				$value['act_desc'] = $this->getActivity($value['weekint_classifier'], $value['weekint_week'], $value['weekint_month']);
				$value['week_name'] = $weekName['week_description'];
				$value['week_int'] = $weekName['week_int'];
				if($value['month_name'] != '')
				{
					$resultArray[$value['month_name']][] = $value;
				}
			}
			$wardsWeather = $resultArray;
			
			$response = [
				'status' => 200,
				'error' => FALSE,
				'messages' => "Data Found",
				'data' => $wardsWeather,
			];
			return $this->respond($response);
		}
	}
	
	public function getWeather2($id)
	{
		$model1 = new WeeklyintensityModel();
		$model2 = new WardsModel();
		$model3 = new WeekModel();
		
		// $currentYear = new Time('now');
        // $currentYear = $currentYear->toLocalizedString('yyyy');
        // $nextYear = new Time('+1 year');
        // $nextYear = $nextYear->toLocalizedString('yyyy');
		
		$wardsWeather = $model1->weatherDataForAPI($id);
		
		if($wardsWeather == false)
		{
			$response = [
				'status' => 500,
				'error' => TRUE,
				'messages' => 'No data'
			];
// 			return $this->respond($response);
					echo '<pre>';
					print_r($response);
		}
		else
		{
			$resultArray = [];
			foreach ($wardsWeather as $key => $value)
			{
				// $weekName = $model3->where('week_id', $value['weekint_week'])->first();
				$weekName = $model3->find($value['weekint_week']);
				$value['act_desc'] = $this->getActivity($value['weekint_classifier'], $value['weekint_week'], $value['weekint_month']);
				$value['week_name'] = $weekName['week_description'];
				$value['week_int'] = $weekName['week_int'];
				if($value['month_name'] != '')
				{
					$resultArray[$value['month_name']][] = $value;
				}
			}
			$wardsWeather = $resultArray;
			
			$response = [
				'status' => 200,
				'error' => FALSE,
				'messages' => "Data Found",
				'data' => $wardsWeather,
			];
// 			return $this->respond($response);                    
					echo '<pre>';
					print_r($response);
		}
	}
}