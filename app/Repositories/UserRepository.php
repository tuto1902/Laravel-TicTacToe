<?php


namespace App\Repositories;


use App\Repositories\Eloquent\Repository;

class UserRepository extends Repository
{

	function model()
	{
		return 'App\User';
	}

	function search($keyword)
	{
		$this->model = $this->model->where('name', 'like', "%{$request->get('search')}%")
	}
}