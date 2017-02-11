<?php

namespace App\Repositories\Criteria\Turn;

use App\Repositories\Criteria;

class NextTurn extends Criteria
{

	public function apply($model)
	{
		return $model->whereNull('location')->orderBy('id')->take(1);
	}
}