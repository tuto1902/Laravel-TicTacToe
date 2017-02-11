<?php


namespace App\Http\Controllers;

use App\Turn;
use Illuminate\Http\Request;

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

		$players = Turn::where('game_id', '=', $id)->select(['player_id', 'type'])->distinct()->get();

		$allowed = $user->id == $players[0]->player_id || $user->id == $players[1]->player_id;
		$playerType = $user->id == $players[0]->player_id ? $players[0]->type : $players[1]->type;
		if(!$allowed){
			return redirect()->back()->with("error", "You are not allowed on that game");
		}

		$pastTurns = Turn::where('game_id', '=', '$id')->whereNotNull('location')->orderBy('id')->get();
		$nextTurn = Turn::where('game_id', '=', '$id')->whereNull('location')->orderBy('id')->first();

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

		$players = Turn::where('game_id', '=', '$id')->select(['player_id', 'type'])->distinct()->get();
		$allowed = $user->id == $players[0]->player_id || $user->id == $players[1]->player_id;

		if(!$allowed){
			return response()->json(["status" => "error", "data" => "You are not in this game"]);
		}

		$location = $request->get('location');
		$turn = Turn::where("game_id", "=", $id)->where("id", "=", $request->get("id"));
		$turn->location = $location;
		$turn->save();
		return response()->json(["status" => "success", "data" => "Saved"]);
	}
}