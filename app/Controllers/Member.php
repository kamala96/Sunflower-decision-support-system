<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\RolesModel;
use App\Models\WardsModel;
use CodeIgniter\RESTful\ResourceController;

class Member extends ResourceController
{
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	public function index()
	{
		$model = new UsersModel();
        $data = $model->findAll();
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => "Members Found",
            "data" => $data,
        ];
        return $this->respond($response);
	}

	/**
	 * Return the properties of a resource object
	 *
	 * @return mixed
	 */
	public function show($id = null)
	{
		$model = new UsersModel();
        $data = $model->where(['id' => $id])->first();
        if ($data) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => "Member Found",
                "data" => $data,
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Member Found with id ' . $id);
        }
	}

	/**
	 * Return a new resource object, with default properties
	 *
	 * @return mixed
	 */
	public function new()
	{
		//
	}

	/**
	 * Create a new resource object, from "posted" parameters
	 *
	 * @return mixed
	 */
	public function create()
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

        $model->insert($data);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => "Member Saved",
        ];
        return $this->respondCreated($response);
	}

	/**
	 * Return the editable properties of a resource object
	 *
	 * @return mixed
	 */
	public function edit($id = null)
	{
		//
	}

	/**
	 * Add or update a model resource, from "posted" properties
	 *
	 * @return mixed
	 */
	public function update($id = null)
	{
		$model = new UsersModel();

        $data = [
            'first_name' => $this->request->getVar('first_name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
        ];

        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => "Data Updated"
        ];
        return $this->respond($response);
	}

	/**
	 * Delete the designated resource object from the model
	 *
	 * @return mixed
	 */
	public function delete($id = null)
	{
		$model = new UsersModel();

        $data = $model->find($id);

        if ($data) {

            $model->delete($id);

            $response = [
                'status' => 200,
                'error' => null,
                'messages' => "Data Deleted",
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
	}
}
