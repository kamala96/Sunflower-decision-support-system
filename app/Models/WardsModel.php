<?php

namespace App\Models;

use CodeIgniter\Model;

class WardsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'wards';
	protected $primaryKey           = 'ward_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'ward_name',
		'ward_slug',
		'ward_district',
		'ward_longtude',
		'ward_latitude',
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
	
	public function weatherData()
	{
		$this->join('weeklyintensities w', 'w.weekint_ward = wards.ward_id', 'LEFT');
		$this->join('districts d', 'd.district_id = wards.ward_district', 'LEFT');
		$this->select('w.*');
		$this->select('d.district_name');
		$this->select('wards.*');
		// $this->orderBy(' wards.ward_id');
		$result = $this->findAll();	
		return $result;
	}
	
	###### API ONLY START #############
	public function getWards()
	{
		$this->join('districts d', 'd.district_id = wards.ward_district', 'LEFT');
		$this->select('d.district_name');
		$this->select('wards.ward_id, wards.ward_name');
		$this->orderBy(' wards.ward_name');
		$result = $this->findAll();
		if( ! empty($result))
		{
			return $result;
		}
		return false;
	}

	public function weatherDataForAPI($id)
	{
		$this->join('weeklyintensities wi', 'wi.weekint_ward = wards.ward_id', 'LEFT');
		// $this->join('wards w', 'w.ward_id = weeklyintensities.weekint_ward', 'LEFT');
		$this->join('districts d', 'd.district_id = wards.ward_district', 'LEFT');
		
		// $this->join('weeks k', 'k.week_id = c.weekint_week', 'LEFT');
		
		$this->join('months m', 'm.month_id = wi.weekint_month', 'LEFT');
		
		// $this->join('activities a', 'a.act_week = k.week_id', 'LEFT');
		$this->join('classifiers c', 'c.c_id = wi.weekint_classifier', 'LEFT');
		// $this->select('w.ward_name');
		$this->select('m.month_name');
		// $this->select('k.week_int');
		$this->select('d.district_name');
		// $this->select('a.act_desc, a.act_requirement, a.act_month');
		$this->select('c.c_desc, c.c_img');
		// $this->select('k.week_int');
		// $this->select('a.act_desc, a.act_requirement, a.act_month');
		$this->select('wi.*');
		$this->select('wards.ward_name');
		$this->where('wards.ward_id', $id);
		// $this->orderBy('d.district_name ASC');
		// $this->orderBy('w.ward_name ASC');
		// $this->orderBy('m.month_int ASC');
		// $this->orderBy('k.week_int ASC');
		$result = $this->findAll();
		if(empty($result))
		{
			return false;
		}
		return $result;
	}
	
	###### API ONLY END #############
}
