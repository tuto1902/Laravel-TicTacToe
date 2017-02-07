<?php

namespace App\Repositories;

use App\Repositories\Eloquent\Repository;

class GameRepository extends Repository
{

	function model()
	{
		return 'App\Game';
	}
}
