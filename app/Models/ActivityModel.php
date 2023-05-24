<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'activities';
	protected $primaryKey           = 'act_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'act_week',
		'act_month',
		'act_desc',
		'act_requirement',
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
	
	public function getActivities()
	{
		$this->join('months m', 'm.month_id = activities.act_month', 'LEFT');
		$this->join('weeks w', 'w.week_id = activities.act_week', 'LEFT');
		// $this->join('classifiers c', 'c.c_id = activities.act_requirement', 'LEFT');
		$this->select('m.month_name');
		$this->select('w.week_description');
		// $this->select('c.c_desc');
		$this->select('activities.*');
		$result = $this->findAll();
		return $result;
	}
	
	public function getActivity($classifier, $week, $month)
	{
		// $this->where('act_requirement', $classifier);
		$this->where('act_week', $week);
		$this->where('act_month', $month);
		$this->HavingLike('act_requirement', $classifier, 'both');
		$result = $this->first();
		if(empty($result))
		{
			return null;
		}
		return $result;
	}

	public function getCurrentReq($row, $new)
	{
		$this->where('act_id', $row);
		$this->notHavingLike('act_requirement', $new, 'both');
		$result = $this->first();
		if(empty($result))
		{
			return null;
		}
		return $result;
	}
	
	public function updateReq($row, $data)
	{
		$this->set('act_requirement', $data);
		$this->where('act_id', $row);
		if($this->update())
		{
			return true;
		}
		return false;
	}

	public function removeContraint($activity, $constraint)
	{
		$this->where('act_id', $activity);
	}
}
