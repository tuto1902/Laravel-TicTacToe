<?php

namespace App\Repositories;

use App\Repositories\Eloquent\Repository;

class TurnRepository extends Repository
{

	function model()
	{
		return 'App\Turn';
	}

	public function find($ids, $columns = ['*'])
	{
		$this->applyCriteria();
		foreach($ids as $key => $value){
			$query = $this->model->where($key, '=', $value);
		}
		return $query->select($columns)->first();
	}
}
