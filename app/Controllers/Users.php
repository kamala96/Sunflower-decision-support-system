<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Models\RolesModel;
use App\Models\WardsModel;
use App\Models\WeeklyintensityModel;
use App\Models\ActivityModel;
use App\Models\WeekModel;
use App\Models\MonthModel;
use App\Models\ClassifierModel;
use App\Models\ViswaswaduModel;


class Users extends BaseController
{
    public function index()
    {
        // $model = new UsersModel();
        helper(['form']);
        $data = [
            'title' => 'DSS Login',
        ];
        return view('pages/login_page', $data);
    }
    
    ##### PROTECTED START ###########
    protected function getWeeks() : array
    {
        return [
            ['id' => 1, 'week_name' => 'First Week'],
            ['id' => 2, 'week_name' => 'Second Week'],
            ['id' => 3, 'week_name' => 'Third Week'],
            ['id' => 4, 'week_name' => 'Fourth Week'],
        ];
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
    ##### PROTECTED END ###########
    
    public function home()
    {
        $session = session();
        $isSuper = $session->get('user_role') == 'super' ? 1 : 0;
        $model1 = new WeeklyintensityModel();
        $model2 = new ActivityModel();
        $model3 = new WardsModel();
        $model4 = new WeekModel();
        
        // $myTime = Time::today();
        $currentYear = new Time('now');
        $currentYear = $currentYear->toLocalizedString('yyyy');
        $nextYear = new Time('+1 year');
        $nextYear = $nextYear->toLocalizedString('yyyy');
        
        // $activities = $model2->findAll();
        // $weather = $model1->weatherData();
        // $weather = $model3->weatherData();
        
        $wardsWeather = $model1->weatherData($isSuper, $session->get('user_ward_id'));
        $resultArray = [];
        foreach ($wardsWeather as $key => $value)
        {
            // $weekName = $model3->where('week_id', $value['weekint_week'])->first();
            $weekName = $model4->find($value['weekint_week']);
            $value['act_desc'] = $this->getActivity($value['weekint_classifier'], $value['weekint_week'], $value['weekint_month']);
            $value['week_description'] = $weekName['week_description'];
            // if($value['month_name'] != ''){$resultArray[] = $value;}
            $resultArray[] = $value;
        }
        $wardsWeather = $resultArray;
        
        $data = [
            'title' => 'Home',
            'wardsWeather' => $wardsWeather,
            'pager' => $model1->pager,
        ];
        return view('pages/main', $data);
    }
    
    public function auth()
    {
        helper(['form']);
        if ($this->request->getMethod() == 'post')
        {
            $rules = [
                'username' => 'required|min_length[6]|max_length[20]',
                'password' => 'required|min_length[6]|max_length[20]',
            ];
            if($this->validate($rules))
            {
                $session = session();
                $model = new UsersModel();
                $username = $this->request->getVar('username');
                $password = $this->request->getVar('password');
                // $data = $model->where('username', $username)->first();
                $allowed_users = array("super", "normal");
                $data = $model->loginByUsername($username);
                if($data && in_array($data["role"], $allowed_users))
                {
                    $pass = $data['password'];
                    $verify_pass = password_verify($password, $pass);
                    if($verify_pass){
                        $ses_data = [
                            'user_id'       => $data['user_id'],
                            'user_name'     => $data['username'],
                            'last_name'     => $data['last_name'],
                            'user_email'    => $data['email'],
                            'user_role'    => $data['role'],
                            'user_ward'    => $data['ward_name'],
                            'user_ward_id'    => $data['ward'],
                            'logged_in'     => TRUE
                        ];
                        $session->set($ses_data);
                        return redirect()->to(base_url('/home'));
                    }
                    else
                    {
                        $session->setFlashdata('err_msg', 'Wrong Password');
                        return redirect()->to('/login');
                    }
                }
                else
                {
                    $session->setFlashdata('err_msg', 'Username not Found');
                    return redirect()->to('/login');
                }
            }
            else
            {
                $data = [
                    'title' => 'Login',
                    'validation' => $this->validator,
                ];
                return view('pages/login_page', $data);
            }
        }
        return redirect()->to(base_url('/login'));
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
    
    
    public function register()
    {
        return view('pages/register_page', ['title' => 'Register']);
    }
    
    public function save()
    {
        //include helper form
        helper(['form']);
        //set rules validation form
        $rules = [
            'first_name'          => 'required|min_length[3]|max_length[20]',
            'last_name'          => 'required|min_length[3]|max_length[20]',
            'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
            'phone'          => 'required|min_length[10]|max_length[15]',
            'password'      => 'required|min_length[6]|max_length[200]',
            'username'          => 'required|min_length[6]|max_length[20]',
            'confpassword'  => 'matches[password]'
        ];
        
        if($this->validate($rules)){
            $model = new UsersModel();
            $data = [
                'first_name'     => $this->request->getVar('first_name'),
                'last_name'     => $this->request->getVar('last_name'),
                'email'    => $this->request->getVar('email'),
                'phone'    => $this->request->getVar('phone'),
                'password'    => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role_id'    => 2,
                'created_by'    => 1,
                'username'    => $this->request->getVar('username')
            ];
            if($model->save($data))
            {
                return redirect()->to('/login');
            }
        }else{
            $data = [
                'title' => 'Register',
                'validation' => $this->validator,
            ];
            return view('pages/register_page', $data);
        }
        
    }
    
    public function profile()
    {
        
        $data = [];
        $model = new UsersModel();
        
        $data = [
            'title' => 'Profile',
            'user' => $model->where('user_id', session()->get('user_id'))->first(),
        ];
        return view('pages/profile_page', $data);
    }
    
    public function passwordForgot()
    {
        $model = new UsersModel();
        if ($this->request->getMethod() === 'post' && $this->validate(['username' => 'required|min_length[6]|max_length[12]', 'password'  => 'required',]))
        {
            $result = $model->save($this->request->getPost('username'), $this->request->getPost('password'));
            if($result)
            {
                echo "view('news/success')";
            }
            else
            {
                echo "no";
            }
        }
        else
        {
            return view('pages/password_page', ['title' => 'Password Recovery']);
        }
    }
    
    public function save_user()
    {
        $session = session();
        //include helper form
        helper(['form']);
        $data = [];
        if($this->request->getMethod() === 'post')
        {
            //set rules validation form
            $rules = [
                'first_name' => 'required|min_length[3]|max_length[20]',
                'last_name'  => 'required|min_length[3]|max_length[20]',
                'phone' => 'required|min_length[10]|max_length[15]|is_unique[users.phone]',
                'role' => 'required|numeric',
                'ward' => 'required|numeric',
                'password' => 'required|min_length[6]|max_length[200]',
                'username' => 'required|min_length[6]|max_length[20]|is_unique[users.username]',
                'confpassword' => 'matches[password]'
            ];
            if($this->request->getVar('email')) $rules['email'] = 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]';
            
            if($this->validate($rules))
            {
                $model = new UsersModel();
                $data = [
                    'first_name'     => $this->request->getVar('first_name'),
                    'last_name'     => $this->request->getVar('last_name'),
                    'phone'    => $this->request->getVar('phone'),
                    'password'    => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'role_id'    => $this->request->getVar('role'),
                    'ward'    => $this->request->getVar('ward'),
                    'created_by'    => session()->get('user_id'),
                    'username'    => $this->request->getVar('username')
                ];
                if($this->request->getVar('email')) $data['email'] = $this->request->getVar('email');
                
                if($model->save($data))
                {
                    // $session->setFlashdata('sucess_msg', 'Added successful');
                    // return redirect()->to('/dashboard/add-user');
                    
                    // Calling name defined in 'as' in Routes.php
                    return redirect()->route("add-user")->with("sucess", "Successfully, data has been saved");
                }
                return redirect()->route("add-user")->with("error", "Oops an error occured, data has not been saved");
            }
            else
            {
                $model = new RolesModel();
                $model2 = new WardsModel();
                $ward_array = $session->get('user_ward') ? array(session()->get('user_ward')) : '';
                print_r($ward_array);
                $data = [
                    'title' => 'Add User Errors',
                    'user_roles' => $model->whereNotIn('role', ['super'])->find(),
                    'list_of_wards' => $model2->orderBy('ward_name', 'ASC')->find(),
                    'validation' => $this->validator
                ];
                return view('pages/add_user_page', $data);
            }
        }
        else
        {
            $model = new RolesModel();
            $model2 = new WardsModel();
            $ward_array = $session->get('user_ward') ? array(session()->get('user_ward')) : '';
            $data = [
                'title' => 'Add User',
                'success_redirect_data' => $session->get("sucess"),
                'error_redirect_data' => $session->get("error"),
                'user_roles' => $model->whereNotIn('role', ['super'])->find(),
                'list_of_wards' => $model2->orderBy('ward_name', 'ASC')->find(),
            ];
            return view('pages/add_user_page', $data);
        }
    }
    
    public function view_ext_officers()
    {
        $model = new UsersModel();
        $model3 = new RolesModel();
        $model2 = new WardsModel();
        helper(['form']);
        $data = [];
        $session = session();
        if($this->request->getMethod() === 'post')
        {
            
            $rules = [
                'first_name' => 'required|min_length[3]|max_length[20]',
                'last_name'  => 'required|min_length[3]|max_length[20]',
                'phone' => 'required|min_length[10]|max_length[15]|is_unique[users.phone]',
                'ward' => 'required|numeric',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]|max_length[200]',
                'username' => 'required|min_length[6]|max_length[20]|is_unique[users.username]',
                'confpassword' => 'matches[password]'
            ];
            
            if($this->validate($rules))
            {
                $role = $model3->where('role', 'normal')->first();
                $data = [
                    'first_name'     => $this->request->getVar('first_name'),
                    'last_name'     => $this->request->getVar('last_name'),
                    'phone'    => $this->request->getVar('phone'),
                    'email' => $this->request->getVar('email'),
                    'password'    => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'role_id'    => $role['role_id'],
                    'ward'    => $this->request->getVar('ward'),
                    'created_by'    => $session->get('user_id'),
                    'username'    => $this->request->getVar('username')
                ];
                if($model->save($data))
                {
                    echo json_encode(array("status" => true , 'data' => 'Success!, added successfully'));
                }
                else
                {
                    echo json_encode(array("status" => false , 'data' => 'Oops an error occured, data has not been saved'));
                }
            }
            else
            {
                $data = $this->validator->listErrors();
                echo json_encode(array("status" => false , 'data' => $data));
            }
        }
        else
        {
            $data = [
                'title' => 'Extenstion Officers',
                'extension_oficcers' => $model->list_users('normal'),
                'list_of_wards' => $model2->orderBy('ward_name', 'ASC')->find(),
            ];
            return view('pages/view_extension_officers_page', $data);
        }
    }
    
    public function list_of_farmers()
    {
        $model = new UsersModel();
        $session = session();
        $data = [
            'title' => 'Farmers',
            'farmers' => $model->list_users('farmer', $session->get("user_ward_id")),
            'success_redirect_data' => $session->get("sucess"),
            'error_redirect_data' => $session->get("error"),
        ];
        return view('pages/viewing_farmers_page', $data);
    }        
    
    public function smsUsers()
    {
        $model1 = new ViswaswaduModel();
        $model2 = new WardsModel();
        $session = session();
        $isSuper = $session->get('user_role') == 'super' ? 1 : 0;
        if ($this->request->getMethod() == 'post')
        {
            $input = $this->validate([
                'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv],'
            ]);
            
            if (!$input)
            {
                $session->setFlashdata('message', $this->validator);
                $session->setFlashdata('alert-class', 'alert-danger');
                $data = [
                    'title' => 'SMS-Farmers',
                    'sms_farmers' => $model1->getUsers(),
                    'success_redirect_data' => $session->get("sucess"),
                    'error_redirect_data' => $session->get("error"),
                ];
                return view('pages/viewing_farmers_page', $data);
            }
            else
            {
                if($file = $this->request->getFile('file'))
                {
                    if ($file->isValid() && ! $file->hasMoved())
                    {
                        $newName = $file->getRandomName();
                        $file->move('../public/csv/', $newName);
                        $file = fopen("../public/csv/".$newName,"r");
                        $i = 0;
                        $numberOfFields = 2;
                        
                        $csvArr = array();
                        $invalid = "";
                        
                        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE)
                        {
                            $num = count($filedata);
                            if($i > 0 && $num == $numberOfFields)
                            { 
                                $numlength = strlen((string)$filedata[0]);
                                if ($numlength == 9)
                                {
                                    $csvArr[$i]['v_phone'] = $filedata[0];
                                    $csvArr[$i]['v_ward'] = $filedata[1];
                                }
                                else
                                {
                                    $invalid .= '&nbsp;'.$filedata[0];
                                }
                                
                            }
                            $i++;
                        }
                        fclose($file);
                        
                        $count = 0;
                        $existing = "";
                        $non_wards = "";
                        foreach($csvArr as $userdata)
                        {
                            $model1 = new ViswaswaduModel();
                            $findRecord = $model1->where('v_phone', $userdata['v_phone'])->countAllResults();
                            
                            if($findRecord == 0)
                            {
                                $findRecordWard = $model2->where('ward_id', $userdata['v_ward'])->countAllResults();
                                if($findRecordWard == 1)
                                {
                                    $userdata['v_ward'] = $isSuper == 1 ? $userdata['v_ward'] : $session->get('user_ward_id');
                                    if($model1->insert($userdata))
                                    {
                                        $count++;
                                    }
                                }
                                else
                                {
                                    $non_wards.= "&nbsp;" . $userdata['v_ward'];
                                }
                            }
                            else
                            {
                                $existing.= "&nbsp;" . $userdata['v_phone'];
                            }
                        }
                        return redirect()->route("smsfarmers")->with("sucess", "Imported: " . $count.", Existing: " . $existing . ", Non-Wards: " . $non_wards . ", Invalid Format: ".$invalid);
                    }
                    else
                    {
                        return redirect()->route("smsfarmers")->with("error", 'CSV file coud not be imported.');
                    }
                }
                else
                {
                    return redirect()->route("smsfarmers")->with("error", 'CSV file coud not be imported.');
                }
            } 
        }
        else
        {
            $data = [
                'title' => 'SMS-Farmers',
                'sms_farmers' => $model1->getUsers($isSuper, $session->get('user_ward_id')),
                'success_redirect_data' => $session->get("sucess"),
                'error_redirect_data' => $session->get("error"),
            ];
            return view('pages/viewing_farmers_page', $data);
        }
    }       
    
    public function removeSmsUser($id)
    {
        $model = new ViswaswaduModel();
        $session = session();
        $model->where('v_id', $id)->delete();
        return redirect()->to(base_url('/home/sms-farmers'));
    }
    
    public function deleteUser()
    {
        helper(["url"]);
        $model = new UsersModel();
        
        $rules = [
            'id' => 'required|integer',
        ];
        
        if($this->validate($rules))
        {
            $delete = $model->where('user_id', $this->request->getVar('id'))->delete();
            if($delete)
            {
                echo json_encode(array("status" => true , 'data' => 'Success!, deleted successifully'));
            }
            else
            {
                echo json_encode(array("status" => false , 'data' => 'Oops an error occured, data has not been deleted'));
            }
        }
        else
        {
            $data = $this->validator->listErrors();
            echo json_encode(array("status" => false , 'data' => $data));
        }
    }     
    
    public function addActivities()
    {
        $model = new ActivityModel();
        $model2 = new WeekModel();
        $model3 = new MonthModel();
        $model4 = new ClassifierModel();
        helper(['form']);
        $data = [];
        $session = session();
        if($this->request->getMethod() === 'post')
        {
            
            $rules = [
                'week' => 'required|numeric',
                'month' => 'required|numeric',
                'description'  => 'required|min_length[3]|max_length[100]',
                'requiremet' => 'required|numeric',
            ];
            
            if($this->validate($rules))
            {
                $data = [
                    'act_week'     => $this->request->getVar('week'),
                    'act_month'     => $this->request->getVar('month'),
                    'act_desc'    => $this->request->getVar('description'),
                    'act_requirement'    => $this->request->getVar('requiremet'),
                ];
                if($model->save($data))
                {
                    echo json_encode(array("status" => true , 'data' => 'Success!, received successfully'));
                }
                else
                {
                    echo json_encode(array("status" => false , 'data' => 'Oops an error occured, data has not been saved'));
                }
            }
            else
            {
                $data = $this->validator->listErrors();
                echo json_encode(array("status" => false , 'data' => $data));
            }
        }
        else
        {
            $allAct = $model->getActivities();
            if(!empty($allAct))
            {
                foreach($allAct as $key => $row)
                {
                    $fullReq = '<span>';
                    $exploded = explode("_", $row['act_requirement']);
                    foreach($exploded as $exp)
                    {
                        $exp = trim($exp);
                        $classifierData = $model4->where('c_id',$exp)->first();
                        $classifierName = $classifierData['c_desc'];
                        $fullReq .= '**'.$classifierName.'&nbsp;<a type="button" class="btn-floating" href="'.base_url('home/activities/remove-constraint/'.$row['act_id'].'/'.$exp).'" title="Remove"><i class="fas fa-minus-circle" aria-hidden="true"></i></a>';
                    } 
                    $fullReq .= '</span>';
                    $allAct[$key]['fullReq'] = $fullReq;
                }
            }
            $data = [
                'title' => 'Seasonal Activities',
                'activities' => $allAct,
                'weeks' => $model2->orderBy('week_int', 'ASC')->findAll(),
                'months' => $model3->orderBy('month_int', 'ASC')->findAll(),
                'classifiers' => $model4->orderBy('c_min', 'ASC')->findAll(),
                'classifiers2' => $model4->getClassifiers(),
            ];
            // echo "<pre>";
            // print_r($allAct);
            return view('pages/activities_page', $data);
        }
    }
    
    public function addActivitiesJSON()
    {
        $rules = [
            'id' => 'required|max_length[10]',
            'add' => 'required|max_length[10]',
        ];
        
        if( ! $this->validate($rules))
        {	
            $data = $this->validator->listErrors();
            echo json_encode(array("status" => false , 'data' => $data));
        }
        else
        {
            $model = new ActivityModel();
            $id = $this->request->getVar('id');
            $add = $this->request->getVar('add');
            
            $get_current = $model->getCurrentReq($id, $add);
            if($get_current != null)
            {
                $new_req = $get_current['act_requirement']."_". $add;
                $update = $model->updateReq($id, $new_req);
                if($update)
                {
                    echo json_encode(array("status" => true , 'data' => 'Success'));
                }
                else
                {
                    echo json_encode(array("status" => false , 'data' => 'Failure'));
                }
            }
            else 
            {
                echo json_encode(array("status" => false , 'data' => 'Failure'));
            }
        }
    }
    
    public function deleteActivity()
    {
        helper(["url"]);
        $model = new ActivityModel();
        
        $rules = [
            'id' => 'required|integer',
        ];
        
        if($this->validate($rules))
        {
            $delete = $model->where('act_id', $this->request->getVar('id'))->delete();
            if($delete)
            {
                echo json_encode(array("status" => true , 'data' => 'Success!, removed successifully'));
            }
            else
            {
                echo json_encode(array("status" => false , 'data' => 'Oops an error occured, data has not been removed'));
            }
        }
        else
        {
            $data = $this->validator->listErrors();
            echo json_encode(array("status" => false , 'data' => $data));
        }
    }
    
    public function removeConstraint($activity, $constraint)
    {
        if( ! empty($activity) && ! empty($constraint))
        {
            if (is_numeric($activity) && is_numeric($constraint))
            {
                $model = new ActivityModel();
                try
                {
                    $data = $model->where('act_id', $activity)->first();
                    $current = $data['act_requirement'];
                    $explode = explode("_", $current);
                    if(count($explode) > 1)
                    {
                        echo $current;
                        if (($key = array_search($constraint, $explode)) !== false) {
                            unset($explode[$key]);
                        }
                        $new = implode("_", $explode);
                        $model->updateReq($activity, $new);
                    }
                }
                catch (\Throwable $e)
                {
                }
            }
        }
        return redirect()->to(base_url('home/activities'));
    }

    public function getApp()
	{
        return $this->response->download('app-debug.apk', null, TRUE);
	}
}