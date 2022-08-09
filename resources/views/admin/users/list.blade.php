@extends('layouts.admin')

@section('title', 'Danh sách người dùng')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách người dùng</h1>
    </div>

    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <p>
        <a href="{{ route('admin.users.add') }}" class="btn btn-primary">Thêm mới</a>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">STT</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Nhóm</th>
                <th width="5%">Sửa</th>
                <th width="5%">Xóa</th>
            </tr>
        </thead>
        <tbody>
            @if ($list->count() > 0)
                @foreach ($list as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->group->name }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Sửa</a>
                        </td>
                        <td>
                            @if (Auth::user()->id !== $user->id)
                                <a onclick="return confirm('Bạn có chắc chắn');"
                                    href="{{ route('admin.users.delete', $user) }}" class="btn btn-danger">Xóa</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
