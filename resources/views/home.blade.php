@extends('layouts.app')

@section('scripts')
<script language="javascript">
    var pusher = new Pusher('4a4eb548348c96e11364');
    var gamePlayChannel = pusher.subscribe('new-game-channel');
    gamePlayChannel.bind('App\\Events\\NewGame', function(data){
        if(data.destinationUserId == '{{ $user->id }}'){
            $('#from').html(data.from);
            $('#new-game-form').attr('action', '/board/' + data.gameId);
            $('#new-game-modal').modal('show');
        }
    });
    $('#play-button').on('click', function(){
        $('#new-game-form').submit();
    });
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="profile-picture">
                        <img class="img-circle img-responsive" src="https://www.gravatar.com/avatar/{{ md5($user->email) }}?d=retro&s=200">
                    </div>
                    <div class="profile-info">
                        <div class="profile-username">{{ $user->name }}</div>
                        <div class="profile-score">{{ $user->score }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-right">
                        <form class="form-inline" method="get">
                            <label>Search: </label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" value="{{ request('search')  }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="list-group">
                        @foreach($users as $_user)
                            <a class="list-group-item clearfix">
                                <img class="img-circle img-responsive" src="https://www.gravatar.com/avatar/{{ md5($_user->email) }}?d=retro">
                                <span class="user-info">
                                    {{ $_user->name }}<br>
                                    <small>Score: {{$_user->score}}</small>
                                </span>
                                <form action="/new-game" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="user_id" value="{{$_user->id}}">
                                    <button type="submit" class="btn btn-primary pull-right">Play</button>
                                </form>
                            </a>
                        @endforeach
                    </div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="new-game-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">New Game</h4>
            </div>
            <div class="modal-body">
                <p><span id="from"></span> invited you to game</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="play-button" type="button">Play</button>
            </div>
        </div>
    </div>
</div>
<form id="new-game-form" method="get">
    {{ csrf_field() }}
</form>
@endsection
