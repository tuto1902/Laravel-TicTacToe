<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $fillable = ['player_one_id', 'player_two_id', 'end_date'];

	public function turns()
	{
		return $this->hasMany('App\Turn', 'game_id');
	}
}
