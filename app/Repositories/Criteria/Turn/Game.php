<?php


namespace App\Repositories\Criteria\Turn;


use App\Repositories\Criteria;

class Game extends Criteria
{
	private $gameId;

	public function __construct($gameId)
	{
		$this->gameId = $gameId;
	}

	public function apply($model)
	{
		return $model->where('game_id', '=', $this->gameId);
	}
}