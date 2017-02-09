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
                            <input type="hidden" id="user-id-{{$_user->id}}">
                            <button type="button" class="btn btn-primary pull-right">Invite</button>
                        </a>
                        @endforeach
                    </div>

                    {{ $users->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
