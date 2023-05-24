<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use Twilio\Rest\Client;

use CodeIgniter\I18n\Time;
use App\Models\ViswaswaduModel;
use App\Models\WeeklyintensityModel;
use App\Models\WeekModel;
use App\Models\ActivityModel;
use App\Models\WardsModel;


class SendSms extends BaseController
{
	public function index()
	{
		$model1 = new ViswaswaduModel();
		$model2 = new WeeklyintensityModel();
		$model3 = new WeekModel();
		$model4 = new WardsModel();
		helper('inflector');
		
		$all_users = $model1->findAll();
		if(empty($all_users))
		{
			echo "Please register at least one sms-client";
		}
		else
		{
			foreach ($all_users as $row) 
			{
				$wardWeather = $model2->weatherDataForAPI($row['v_ward']);
				if($wardWeather == false)
				{
					echo "No SMS data";
				}
				else
				{	
					$ward = $model4->where('ward_id', $row['v_ward'])->first();
					$wardName = $ward['ward_name'];
					$smsBody = "SMART-KILIMO\n";
					$smsBody .= strtoupper($wardName." Sunflower\n");
					
					foreach ($wardWeather as $key => $value)
					{
						$weekName = $model3->find($value['weekint_week']);
						$activity = $this->getActivity($value['weekint_classifier'], $value['weekint_week'], $value['weekint_month']);
						
						$smsBody .= "\n".ordinalize($weekName['week_int'])."-week-".$value['month_name'].": " .$value['c_desc'];
						$smsBody .= $activity != null ? "[".$activity."]" : "[No activity]";
					}
				// 	echo "<pre/>";
				// 	echo($smsBody);
					$client = "+255".$row['v_phone'];
					$this->send_SMS($client, $smsBody);	
				}
			}
		}
	}
	
	public function addSMSUsers()
	{
		$input = $this->validate([
			'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
		]);
		
		if (!$input)
		{
			$data['validation'] = $this->validator;
			echo "<pre>";
			print_r ($data); 
		}
		else
		{
			if($file = $this->request->getFile('file'))
			{
				if ($file->isValid() && ! $file->hasMoved())
				{
					$newName = $file->getRandomName();
					$file->move('../public/csvfile', $newName);
					$file = fopen("../public/csvfile/".$newName,"r");
					$i = 0;
					$numberOfFields = 2;
					
					$csvArr = array();
					
					while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE)
					{
						$num = count($filedata);
						if($i > 0 && $num == $numberOfFields)
						{ 
							$csvArr[$i]['phone'] = $filedata[0];
							$csvArr[$i]['ward'] = $filedata[1];
							
						}
						$i++;
					}
					fclose($file);
					
					$count = 0;
					foreach($csvArr as $userdata)
					{
						$model1 = new ViswaswaduModel();
						
						$findRecord = $model1->where('phone', $userdata['phone'])->countAllResults();
						
						if($findRecord == 0)
						{
							if($model1->insert($userdata))
							{
								$count++;
							}
						}
					}
					session()->setFlashdata('message', $count.' rows successfully added.');
					session()->setFlashdata('alert-class', 'alert-success');
				}
				else{
					session()->setFlashdata('message', 'CSV file coud not be imported.');
					session()->setFlashdata('alert-class', 'alert-danger');
				}
			}else{
				session()->setFlashdata('message', 'CSV file coud not be imported.');
				session()->setFlashdata('alert-class', 'alert-danger');
			}
			
		}
		
		return redirect()->route('/home/farmers');         
	}
	
	protected function send_SMS($to, $content)
	{	
		// Find your Account SID and Auth Token at twilio.com/console
		// and set the environment variables. See http://twil.io/secure
		$sid = getenv("TWILIO_ACCOUNT_SID");
		$token = getenv("TWILIO_AUTH_TOKEN");
		$twilio = new Client($sid, $token);
		
		$message = $twilio->messages
		->create($to, // to
		[
			"body" => "Hi ".$to."\n\n".$content,
			"from" => "+12392373298"
			]
		);
		
		// print($message->sid);
		// print($message);
		echo "<code>";
		print $message->status;
		echo ": ".$to."<br />";
	}
	
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
}