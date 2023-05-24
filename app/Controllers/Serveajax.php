<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Controllers\BaseController;

class Serveajax extends BaseController
{
	public function index()
	{
		//
	}

	public function saveUser()
    {
        helper(["url"]);

        if ($this->request->getMethod() == "post") {

            $userModel = new UserModel();

            $data = [
                "name" => $this->request->getVar("name"),
                "email" => $this->request->getVar("email"),
                "mobile" => $this->request->getVar("mobile"),
            ];

            if ($userModel->insert($data)) {

                echo json_encode(array("status" => true, "message" => "User created"));
            } else {

                echo json_encode(array("status" => false, "message" => "Failed to create user"));
            }
        }
    }
}
