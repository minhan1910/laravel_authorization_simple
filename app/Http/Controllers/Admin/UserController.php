<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // không nên dùng all
        $list = User::all();
        return view('admin.users.list', compact('list'));
    }

    public function add()
    {
        $groups = Groups::all();
        return view('admin.users.add', compact('groups'));
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required',
                'group_id'  => ['required', function ($attribute, $value, $fail) {
                    if ($value === '0') $fail('Vui lòng chọn nhóm');
                }]
            ],
            [
                'name.required'     => 'Tên không được để trống',
                'email.required'    => 'Email không được để trống',
                'email.email'       => 'Email không đúng định dạng',
                'email.unique'      => 'Email đã có người sử dụng',
                'password.required' => 'Mật khẩu không được để trống',
                'group_id.required' => 'Nhóm không được để trống',
            ]
        );

        $user = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group_id;
        $user->user_id  = Auth::user()->id;
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('msg', 'Thêm người dùng thành công');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit');
    }

    public function postEdit(User $user)
    {
    }

    public function delete(User $user)
    {
    }
}