<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Movie;
use App\Models\Subscription;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalMovies = Movie::count();
        $totalSubscriptions = Subscription::count();

        return view('admin.dashboard', compact('totalUsers', 'totalMovies', 'totalSubscriptions'));
    }

    public function users()
    {
        $users = User::with('subscription')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function movies()
    {
        $movies = Movie::paginate(10);
        return view('admin.movies', compact('movies'));
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::paginate(10);
        return view('admin.subscriptions', compact('subscriptions'));
    }

    public function comments()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $comments = Comment::with(['user', 'movie'])->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }
}
