<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index', [
            'users' => User::all()->count() ,
            'posts' => Post::all()->count(),
            'categories' => Category::all()->count()
            ]);
    }
}
