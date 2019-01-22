<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $tags = Tag::inRandomOrder()->take(10)->whereHas('posts')->get();
        $popular = Post::with('tags', 'user')->latest('claps')->limit(4)->get();
        return view('landing', compact('tags', 'popular'));
    }
}
