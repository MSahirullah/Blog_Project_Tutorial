<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\Post;
use DateTime;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     return $this->middleware(Authenticate::class)->only(['index']);
    //     // return $this->middleware('verified')->only(['index']);               //only email verified users can see this index page
    //     // return $this->middleware(EnsureEmailIsVerified::class)->only(['index']);
    //     // return $this->middleware('auth')->except(['index']);
    // }

    public function index()
    {
        $today = new \DateTime();

        return view('home.index', [
            'posts' => Post::where('featured', true)->whereNotNull('published_at')->where('published_at', '<=', $today)->latest()->take(3)->get(),
        ]);
    }
}
