<?php

namespace App\Http\Controllers;


use App\Events\NewGame;
use App\Game;
use App\Turn;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $usersQuery = User::where('id', '!=', $user->id);

        if($request->has('search')){
            $usersQuery->where('name', 'like', "%{$request->get('search')}%");
        }

        $users = $usersQuery->paginate(5);

        return view('home', compact('user', 'users'));
    }

    public function newGame(Request $request)
    {
        $user = $request->user();
        $otherUserId = $request->get('user_id');
        $gameId = Game::insertGetId([]);
        for($i = 1; $i <= 9; $i++){
            Turn::insert([
                "game_id" => $gameId,
                "id" => $i,
                "type" => $i % 2 ? 'x' : 'o',
                "player_id" => $i % 2 ? $user->id : $otherUserId
            ]);
        }

        event(new NewGame($otherUserId, $gameId, $user->name));

        return redirect("/board/{$gameId}");

    }
}
