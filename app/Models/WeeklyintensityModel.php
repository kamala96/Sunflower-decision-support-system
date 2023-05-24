<?php

namespace App\Models;

use CodeIgniter\Model;

class WeeklyintensityModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'weeklyintensities';
	protected $primaryKey           = 'weekint_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'weekint_ward',
		'weekint_week',
		'weekint_month',
		'weekint_mm',
		'weekint_classifier',
		'last_created',
	];
	
	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';
	
	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;
	
	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
	
	public function weatherData($isSuper, $ward)
	{
		$this->join('wards w', 'w.ward_id = weeklyintensities.weekint_ward', 'LEFT');
		$this->join('districts d', 'd.district_id = w.ward_district', 'LEFT');		
		$this->join('months m', 'm.month_id = weeklyintensities.weekint_month', 'LEFT');
		$this->join('classifiers c', 'c.c_id = weeklyintensities.weekint_classifier', 'LEFT');
		$this->select('w.ward_name');
		$this->select('m.month_name');
		$this->select('d.district_name');
		$this->select('c.c_desc, c.c_img');
		$this->select('weeklyintensities.*');
		$isSuper == 1 ?: $this->where('w.ward_id', $ward);
		$this->orderBy('d.district_name ASC');
		$this->orderBy('w.ward_name ASC');
		$this->orderBy('m.month_int ASC');
		$result = $this->paginate(12);
		return $result;
	}
	
	public function weatherDataForAPI($id)
	{
		$this->join('wards w', 'w.ward_id = weeklyintensities.weekint_ward', 'LEFT');
		$this->join('districts d', 'd.district_id = w.ward_district', 'LEFT');		
		$this->join('months m', 'm.month_id = weeklyintensities.weekint_month', 'LEFT');
		$this->join('classifiers c', 'c.c_id = weeklyintensities.weekint_classifier', 'LEFT');
		$this->select('w.ward_name');
		$this->select('m.month_name');
		$this->select('d.district_name');
		$this->select('c.c_desc, c.c_img');
		$this->select('weeklyintensities.*');
		$this->where('w.ward_id', $id);
		$this->orderBy('m.month_int ASC');
		$result = $this->findAll();
		if(empty($result))
		{
			return false;
		}
		return $result;
	}
}