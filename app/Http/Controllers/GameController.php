<?php


namespace App\Http\Controllers;

use App\Repositories\Criteria\Turn\Distinct;
use App\Repositories\Criteria\Turn\Game;
use App\Repositories\Criteria\Turn\NextTurn;
use App\Repositories\Criteria\Turn\PastTurns;
use Illuminate\Http\Request;
use App\Repositories\TurnRepository as Turn;

class GameController
{
	private $turns;

	public function __construct(Turn $turns)
	{
		$this->turns = $turns;
	}

	public function board(Request $request, $id)
	{
		$user = $request->user();
		$turnGameCriteria = new Game($id);
		$players = $this->turns
			->pushCriteria($turnGameCriteria)
			->pushCriteria(new Distinct())
			->all(['player_id', 'type']);
		$allowed = $user->id == $players[0]->player_id || $user->id == $players[1]->player_id;
		if(!$allowed){
			return redirect()->back()->with("error", "You are not allowed on that game");
		}
		$playerType = $user->id == $players[0]->player_id ? $players[0]->type : $players[1]->type;
		$pastTurns = $this->turns
			->resetCriteria()
			->pushCriteria($turnGameCriteria)
			->pushCriteria(new PastTurns())
			->all();
		$nextTurn = $this->turns
			->resetCriteria()
			->pushCriteria($turnGameCriteria)
			->pushCriteria(new NextTurn())
			->first();

		$locations = [
			1 => [
				"class" => "top left",
				"checked" => false,
				"type" => ""
			],
			2 => [
				"class" => "top middle",
				"checked" => false,
				"type" => ""
			],
			3 => [
				"class" => "top right",
				"checked" => false,
				"type" => ""
			],
			4 => [
				"class" => "center left",
				"checked" => false,
				"type" => ""
			],
			5 => [
				"class" => "center middle",
				"checked" => false,
				"type" => ""
			],
			6 => [
				"class" => "center right",
				"checked" => false,
				"type" => ""
			],
			7 => [
				"class" => "bottom left",
				"checked" => false,
				"type" => ""
			],
			8 => [
				"class" => "bottom middle",
				"checked" => false,
				"type" => ""
			],
			9 => [
				"class" => "bottom right",
				"checked" => false,
				"type" => ""
			],
		];


		foreach($pastTurns as $pastTurn){
			$locations[$pastTurn->location]["checked"] = true;
			$locations[$pastTurn->location]["type"] = $pastTurn->type;
		}

		return view('board', compact('user', 'nextTurn', 'locations', 'playerType'));
	}

	public function play(Request $request, $id)
	{
		$user = $request->user();
		$turnGameCriteria = new Game($id);
		$players = $this->turns
			->pushCriteria($turnGameCriteria)
			->pushCriteria(new Distinct())
			->all(['player_id', 'type']);
		$allowed = $user->id == $players[0]->player_id || $user->id == $players[1]->player_id;
		if(!$allowed){
			return response()->json(["status" => "error", "data" => "You are not in this game"]);
		}
		$location = $request->get('location');
		$turn = $this->turns->resetCriteria()->find(["game_id" => $id, "id" => $request->get("id")]);
		$turn->location = $location;
		$turn->save();
		return response()->json(["status" => "success", "data" => "Saved"]);
	}
}