<?php

namespace App\Models;

use CodeIgniter\Model;

class ViswaswaduModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'viswaswadu';
	protected $primaryKey           = 'v_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['v_phone', 'v_ward'];

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

	public function getUsers($isSuper, $ward)
	{
		$this->join('wards w', 'w.ward_id = viswaswadu.v_ward', 'LEFT');
		$this->join('districts d', 'd.district_id = w.ward_district', 'LEFT');
		$this->select('w.ward_name');
		$this->select('d.district_name');
		$this->select('viswaswadu.*');
		$isSuper ?: $this->where('w.ward_id', $ward);
		$result = $this->findAll();
		if(empty($result))
		{
			return false;
		}
		return $result;
	}
}
