<?php


namespace App\Repositories\Criteria\Turn;


use App\Repositories\Criteria;

class Distinct extends Criteria
{

	public function apply($model)
	{
		return $model->distinct();
	}
}