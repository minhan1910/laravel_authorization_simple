@extends('layouts.admin')

@section('title', 'Danh sách bài viết')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách bài viết</h1>
    </div>

    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <p>
        <a href="{{ route('admin.posts.add') }}" class="btn btn-primary">Thêm mới</a>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr style="text-align: center;">
                <th width="5%">STT</th>
                <th>Tiêu đề</th>
                <th width="20%">Người đăng</th>
                <th width="5%">Sửa</th>
                <th width="5%">Xóa</th>
            </tr>
        </thead>
        <tbody>
            @if ($posts->count() > 0)
                @foreach ($posts as $key => $post)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $post->title }}</td>
                        <td>
                            {{ !empty($post->postBy->name) ? $post->postBy->name : false }}
                        </td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">Sửa</a>
                        </td>
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn');" href="{{ route('admin.posts.delete', $post) }}"
                                class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
