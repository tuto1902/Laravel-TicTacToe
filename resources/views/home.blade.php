@extends('layouts.app')

@section('styles')
<style type="text/css">
    .list-group-item .img-responsive {
        float: left;
        margin-right: 20px;
    }

    .list-group-item .user-info {
        position: relative;
        top: 15px;
    }

    .list-group {
        margin-top: 15px;
    }
</style>
@endsection

@section('scripts')
<script language="javascript">
    var pusher = new Pusher('4a4eb548348c96e11364');
    var gamePlayChannel = pusher.subscribe('new-game-channel');
    gamePlayChannel.bind('App\\Events\\NewGame', function(data) {
        if(data.destinationUserId == '{{$user->id}}'){
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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="profile-picture">
                        <img class="img-responsive img-circle" src="https://www.gravatar.com/avatar/{{ md5($user->email) }}?d=retro&s=200">
                    </div>
                    <div class="profile-info">
                        <div class="profile-username">{{$user->name}}</div>
                        <div class="profile-score">Score: {{$user->score}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-right">
                            <form id="search-form" class="form-inline" method="get">
                                <form-group>
                                    <label>Search: </label>
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" value="{{request('search')}}">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form-group>
                            </form>
                        </div>
                    </div>
                    <div class="list-group">
                        @foreach($users as $_user)
                        <a class="list-group-item clearfix" class="list-group-item">
                            <img class="img-responsive img-circle" src="https://www.gravatar.com/avatar/{{ md5($_user->email) }}?d=retro&">
                            <span class="user-info">
                                {{$_user->name}}<br>
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
<form id="new-game-form" method="get">
    {{ csrf_field() }}
</form>
<div class="modal fade" id="new-game-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Game</h4>
            </div>
            <div class="modal-body">
                <p><span id="from"></span> invited you to a game</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Not now</button>
                <button id="play-button" type="button" class="btn btn-primary">Play</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
