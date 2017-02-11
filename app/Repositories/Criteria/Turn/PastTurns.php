<?php


namespace App\Repositories\Criteria\Turn;


use App\Repositories\Criteria;

class PastTurns extends Criteria
{

	public function apply($model)
	{
		return $model->whereNotNull('location')->orderBy('id');
	}
}