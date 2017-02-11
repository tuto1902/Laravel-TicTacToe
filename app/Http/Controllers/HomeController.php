<?php

namespace App\Http\Controllers;


use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $
    public function __construct(UserRepository $users)
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
}
