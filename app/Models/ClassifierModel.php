<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassifierModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'classifiers';
	protected $primaryKey           = 'c_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'c_min',
		'c_max',
		'c_desc',
		'c_img',
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
	
	public function getClassifiers()
	{
		$this->select('c_id, c_desc');
		$results = $this->findAll();
		
		$results = array_map(function($result) {
			return array(
				'value' => $result['c_id'],
				'text' => $result['c_desc']
			);
		}, $results);
		return $results;
	}
}
