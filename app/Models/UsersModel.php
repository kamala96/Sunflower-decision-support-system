<?php

namespace App\Models;

use CodeIgniter\Model;

class usersModel extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'user_id';
    protected $allowedFields = [
		'first_name',
		'last_name',
		'email','phone',
		'username',
		'password',
		'role_id',
		'ward',
		'created_by',
		'created_at',
	];

	public function loginByUsername($username)
	{
		$this->join('user_roles', 'user_roles.role_id = users.role_id', 'LEFT');
		$this->join('wards', 'wards.ward_id = users.ward', 'LEFT');
		$this->select('user_roles.role');
		$this->select('wards.ward_name');
		$this->select('users.*');
		$this->where('users.username', $username);
		// $this->orderBy('users.id');
		$result = $this->first();
	
		// echo $this->db->getLastQuery();
		// print_r($result);
	
		return $result;
	}
	
	public function list_users($role = false, $ward = false)
	{
		$this->join('user_roles', 'user_roles.role_id = users.role_id', 'LEFT');
		$this->join('wards', 'wards.ward_id = users.ward', 'LEFT');
		$this->join('districts', 'districts.district_id = wards.ward_district', 'LEFT');
		$this->join('regions', 'regions.region_id = districts.district_region', 'LEFT');
		$this->select('wards.ward_name');
		$this->select('districts.district_name');
		$this->select('regions.region_name');
		$this->select('users.*');
		$role ? $this->where('user_roles.role', $role) : '';
		$ward ? $this->where('users.ward', $ward) : '';
		// $this->orderBy('users.id');
		$result = $this->findAll();
	
		// echo $this->db->getLastQuery();
		// print_r($result);
	
		return $result;
	}

	
}