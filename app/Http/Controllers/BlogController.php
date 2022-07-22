<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // public function __construct()
    // {
    //     // $this->middleware();
    //     //when you need to show posts to  auth users 
    // }

    public function index()
    {
        return view('pages.blog.index');
    }

    // public function FunctionName(Type $var = null)
    // {
    //     # code...
    // }

    public function show(Post $post)
    {
        return view('pages.blog.show', compact('post'));
    }
}
