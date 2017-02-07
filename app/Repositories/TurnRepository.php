<?php

namespace App\Repositories;

use App\Repositories\Eloquent\Repository;

class TurnRepository extends Repository
{

	function model()
	{
		return 'App\Turn';
	}
}
