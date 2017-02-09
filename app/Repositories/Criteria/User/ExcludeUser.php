<?php

namespace App\Repositories\Criteria\User;

use App\Repositories\Criteria;

class ExcludeUser extends Criteria
{
	private $userId;

	public function __construct($userId)
	{
		$this->userId = $userId;
	}

	public function apply($model)
	{
		return $model->where('id', '!=', $this->userId);
	}
}