<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(){

    }

    public function about(){
        return view('frontend.homepage.about');
    }

    public function contact(){
        return view('frontend.homepage.contact');
    }

    public function blog(){
        $posts = Post::where('publish', 2)->get();
        return view('frontend.homepage.blog', compact('posts'));
    }
}
