<?php


namespace App\Repositories\Criteria\User;


use App\Repositories\Criteria;

class Search extends Criteria
{

	private $keyword;

	public function __construct($keyword)
	{
		$this->keyword = $keyword;
	}

	public function apply($model)
	{
		return $model->where('name', 'like', "%{$this->keyword}%");
	}
}