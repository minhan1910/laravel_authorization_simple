<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::all();
        return view('admin.posts.list', compact('posts'));
    }

    public function add()
    {
    }

    public function postAdd(Request $request)
    {
    }

    public function edit(Posts $post)
    {
    }

    public function postEdit(Request $request)
    {
    }

    public function delete(Posts $post)
    {
    }
}