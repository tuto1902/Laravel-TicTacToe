<?php

namespace App;

use App\Model\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
	use HasCompositePrimaryKey;

	public $incrementing = false;
	protected $primaryKey = ['id', 'game_id'];
    public $fillable = ['player_id', 'location', 'type', 'game_id', 'id'];

	public function game()
	{
		return $this->belongsTo('App\Game', 'game_id');
	}
}
