@extends('layouts.admin')

@section('title', 'Thêm người dùng')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm nhóm</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger text-center">Vui lòng kiểm tra dữ liệu nhập vào</div>
    @endif

    <form action="" method="POST">
        @csrf
        <div class="mb-3">
            <label for="">Tên</label>
            <input name="name" type="text" class="form-control" placeholder="Tên..." value="{{ old('name') }}" />

            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
    </form>

@endsection
