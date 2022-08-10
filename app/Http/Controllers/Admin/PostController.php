<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::orderBy('created_at', 'desc')->get();
        return view('admin.posts.list', compact('posts'));
    }

    public function add()
    {
        return view('admin.posts.add');
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Tiêu đề bắt buộc phải nhập',
                'content.required' => 'Nội dung bắt buộc phải nhập'
            ]
        );

        $post = new Posts;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();

        return redirect()
            ->route('admin.posts.index')
            ->with('msg', 'Thêm bài viết thành công');
    }

    public function edit(Posts $post, Request $request)
    {
        $request->session()->put('postId', $post->id);
        return view('admin.posts.edit', compact('post'));
    }

    public function postEdit(Request $request)
    {
        $postId = session('postId');

        if (!$postId)
            return back()->with('msg', 'Bài viết không tồn tại');

        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Tiêu đề bắt buộc phải nhập',
                'content.required' => 'Nội dung bắt buộc phải nhập'
            ]
        );

        $post = Posts::find($postId);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return back()->with('msg', 'Cập nhật bài viết thành công');
    }

    public function delete(Posts $post)
    {
        Posts::destroy($post->id);
        return redirect()->route('admin.posts.index')->with('msg', 'Xóa bài viết thành công');
    }
}