<?php

namespace App\Http\Controllers;

use App\Repositories\Criteria\User\ExcludeUser;
use App\Repositories\Criteria\User\Search;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');
        $this->users = $users;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        if($request->has('search')){
            $this->users->pushCriteria(new Search($request->get('search'), ['name']));
        }
        $users = $this->users->pushCriteria(new ExcludeUser($user->id))->paginate(5);
        return view('home', compact('user', 'users'));
    }
}
