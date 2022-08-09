@extends('layouts.admin')

@section('title', 'Cập nhật người dùng')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cập nhật người dùng</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger text-center">Vui lòng kiểm tra dữ liệu nhập vào</div>
    @endif
    @if (session('msg'))
        <div class="alert alert-success text-center">Cập nhật người dùng thành công</div>
    @endif

    <form action="{{ route('admin.users.user-edit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="">Tên</label>
            <input name="name" type="text" class="form-control" placeholder="Tên..."
                value="{{ old('name') ?? $user->name }}" />

            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Email</label>
            <input name="email" type="text" class="form-control" placeholder="Email..."
                value="{{ old('email') ?? $user->email }}" />

            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Mật khẩu (Không nhập nếu không đổi)</label>
            <input name="password" type="password" class="form-control" placeholder="Mật khẩu..." />

            @error('password')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="">Nhóm</label>
            <select name="group_id" class="form-control">
                <option value="0">Chọn nhóm</option>
                @if ($groups->count() > 0)
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}"
                            {{ $user->group_id === $group->id || old('group_id') === strval($user->group_id) ? 'selected' : false }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                @endif
            </select>

            @error('group_id')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>

@endsection
