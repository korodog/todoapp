<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function authUser()
    {
        return Auth::user();
    }

    public function authCheck()
    {
        return Auth::check();
    }

    public function tasks()
    {
        if(Auth::check()) {
            $tasks = Task::where('status', false)->where('user_id', Auth::user()->id)->get();
            return $tasks;
        }
    }
}
