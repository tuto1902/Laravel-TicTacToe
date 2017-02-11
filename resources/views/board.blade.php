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
    $(document).ready(function () {
        $('input[type=radio]').on('click', function(){
            $.ajax({
                url: '/play/{{$nextTurn->game_id}}',
                method: 'POST',
                data: {
                    id: '{{$nextTurn->id}}',
                    location: $(this).val(),
                    _token: $('input[name=_token]').val()
                },
                success: function(data){
                    if(data.status == 'success'){
                        alert('turn saved');
                    }
                    else{
                        alert(data.data);
                    }
                }
            });
        });
    })
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-picture">
                <img class="img-responsive img-circle" src="https://www.gravatar.com/avatar/{{ md5($user->email) }}?d=retro">
            </div>
            <div class="profile-info">
                <div class="profile-username">{{$user->id == $nextTurn->player_id ? "You are next!" : "Waiting on player #2..."}}</div>
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
@endsection
