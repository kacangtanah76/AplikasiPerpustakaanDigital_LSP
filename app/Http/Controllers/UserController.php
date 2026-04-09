<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::paginate(15);
        $totalUsers = User::where('role', 'user')->count();
        $adminCount = User::where('role', 'admin')->count();
        $studentCount = User::where('role', 'user')->count();

        return view('users', compact('users', 'totalUsers', 'adminCount', 'studentCount'));
    }
}
