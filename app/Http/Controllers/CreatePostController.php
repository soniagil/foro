<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class CreatePostController extends Controller
{
    public function create()
    {
    	return view('posts.create');
    }

    public function store(Request $request)
    {
        // @todo: Add validation

    	$post = new Post($request->all());

    	auth()->user()->posts()->save($post);

    	return $post->title;
    }
}
