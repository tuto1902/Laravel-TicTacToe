@extends('layouts.app')

@section('styles')
<style type="text/css">
    .profile-picture img {
        width: 10%;
        min-width: 64px;
    }
</style>
@endsection

@section('scripts')
<script language="JavaScript">

    function checkResult(){
        var win = false;
        // Top Row
        if($('#block-1.player-{{$playerType}}:checked').length && $('#block-2.player-{{$playerType}}:checked').length && $('#block-3.player-{{$playerType}}:checked').length){
            win = true;
        }
        // Middle Row
        else if ($('#block-4.player-{{$playerType}}:checked').length && $('#block-5.player-{{$playerType}}:checked').length && $('#block-6.player-{{$playerType}}:checked').length){
            win = true;
        }
        // Bottom Row
        else if ($('#block-7.player-{{$playerType}}:checked').length && $('#block-8.player-{{$playerType}}:checked').length && $('#block-9.player-{{$playerType}}:checked').length){
            win = true;
        }
        // Left Col
        else if ($('#block-1.player-{{$playerType}}:checked').length && $('#block-4.player-{{$playerType}}:checked').length && $('#block-7.player-{{$playerType}}:checked').length){
            win = true;
        }
        // Center Col
        else if ($('#block-2.player-{{$playerType}}:checked').length && $('#block-5.player-{{$playerType}}:checked').length && $('#block-8.player-{{$playerType}}:checked').length){
            win = true;
        }
        // Right Col
        else if ($('#block-3.player-{{$playerType}}:checked').length && $('#block-6.player-{{$playerType}}:checked').length && $('#block-9.player-{{$playerType}}:checked').length){
            win = true;
        }
        // Diagonal Left to Right
        else if ($('#block-1.player-{{$playerType}}:checked').length && $('#block-5.player-{{$playerType}}:checked').length && $('#block-9.player-{{$playerType}}:checked').length){
            win = true;
        }
        // Diagonal Right to Left
        else if ($('#block-3.player-{{$playerType}}:checked').length && $('#block-5.player-{{$playerType}}:checked').length && $('#block-7.player-{{$playerType}}:checked').length){
            win = true;
        }

        if(!win){
            if($('input[type=radio]:checked').length == 9){
                return 'tie'
            }
        }
        else{
            return 'win'
        }

        return false;
    }

    $(document).ready(function () {
        $('input[type=radio]').on('click', function(){
            $('input[type=radio]').attr('disabled', true);
            var result = checkResult();
            if(!result){
                $('.profile-username').html('Waiting on player 2...');
                $.ajax({
                    url: '/play/{{$nextTurn->game_id}}',
                    method: 'POST',
                    data: {
                        location: $(this).val(),
                        _token: $('input[name=_token]').val()
                    },
                    success: function(data){
                        if(data.status == 'success'){
                            console.log('Play saved');
                        }
                        else{
                            alert(data.data);
                        }
                    }
                });
            }
            else{
                if(result == 'win'){
                    $('.profile-username').html('You win!');
                }
                else{
                    $('.profile-username').html('Its a tie!');
                }
                $('#exit-button').show();
                $.ajax({
                    url: '/game-over/{{$nextTurn->game_id}}',
                    method: 'POST',
                    data: {
                        location: $(this).val(),
                        result: result,
                        _token: $('input[name=_token]').val()
                    },
                    success: function(data){
                        if(data.status == 'success'){
                            console.log('Play saved');
                        }
                        else{
                            alert(data.data);
                        }
                    }
                });
            }
        });
    });

    var pusher = new Pusher('4a4eb548348c96e11364');
    var gamePlayChannel = pusher.subscribe('game-channel-{{$id}}-{{$otherPlayerId}}');
    var gameOverChannel = pusher.subscribe('game-over-channel-{{$id}}-{{$otherPlayerId}}');
    gamePlayChannel.bind('App\\Events\\Play', function(data) {
        $('#block-' + data.location).removeClass('player-{{$playerType}}').addClass('player-' + data.type);
        $('#block-' + data.location).attr('checked', true);
        $('input[type=radio]').removeAttr('disabled');
        $('.profile-username').html('You are next!');

    });
    gameOverChannel.bind('App\\Events\\GameOver', function(data) {
        $('#block-' + data.location).removeClass('player-{{$playerType}}').addClass('player-' + data.type);
        $('#block-' + data.location).attr('checked', true);
        if(data.result == 'win'){
            $('.profile-username').html('You loose!');
        }
        else{
            $('.profile-username').html('Its a tie!');
        }
        $('#exit-button').show();
    });
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-info">
                <div class="profile-username">{{$user->id == $nextTurn->player_id ? "You are next!" : "Waiting on player 2..."}}</div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {{ csrf_field() }}
        <div class="tic-tac-toe">
            @foreach($locations as $index => $location)
                    <input class="player-{{$location["checked"] ? $location["type"] : $playerType}} {{$location["class"]}}" id="block-{{$index}}" value="{{$index}}" type="radio" {{$location["checked"] ? "checked" : ""}} {{$user->id != $nextTurn->player_id ? "disabled" : ""}}/>
                    <label for="block-{{$index}}"></label>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <a id="exit-button" href="/home" class="btn btn-lg btn-primary" style="display: none">Exit Game</a>
    </div>
</div>
@endsection
