@extends('layouts.admin')

@section('title', 'Danh sách người dùng')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách nhóm</h1>
    </div>

    @if (session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <p>
        <a href="{{ route('admin.groups.add') }}" class="btn btn-primary">Thêm mới</a>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr style="text-align: center;">
                <th width="5%">STT</th>
                <th>Tên</th>
                <th width="20%">Người đăng</th>
                <th width="13%">Phân quyền</th>
                <th width="5%">Sửa</th>
                <th width="5%">Xóa</th>
            </tr>
        </thead>
        <tbody>
            @if ($list->count() > 0)
                @foreach ($list as $key => $group)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $group->name }}</td>
                        <td>
                            {{ !empty($group->postBy->name) ? $group->postBy->name : false }}
                        </td>
                        <td>
                            <a href="{{ route('admin.groups.permission', $group) }}"
                                class="btn btn-primary form-control">Phân
                                quyền</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-warning">Sửa</a>
                        </td>
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn');"
                                href="{{ route('admin.groups.delete', $group) }}" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
