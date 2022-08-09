<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Groups;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user = null;

    public function __construct()
    {
        $this->user = new User;
    }

    public function index()
    {
        // không nên dùng all
        $list = User::all();
        return view('admin.users.list', compact('list'));
    }

    public function add(Request $request)
    {
        $groups = Groups::all();

        $this->setSession($request, 'passwordRequiredRule', 'required');

        return view('admin.users.add', compact('groups'));
    }

    public function postAdd(UserRequest $request)
    {
        $this
            ->getDataUserFromRequest($request)
            ->save();

        return redirect()
            ->route('admin.users.index')
            ->with('msg', 'Thêm người dùng thành công');
    }

    public function edit(Request $request, User $user)
    {
        $groups = Groups::all();

        $this->setSession($request, 'id', $user->id);

        return view('admin.users.edit', compact('groups', 'user'));
    }

    public function postEdit(UserRequest $request)
    {
        $id = session('id');

        if (!$id)
            return back()->with('msg', 'Liên kết không tồn tại');

        $password = $this->setUserPassword($request, $id);

        $newUser = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'group_id' => $request->group_id,
            'user_id' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->user->updateUser($newUser, $id);

        return back()->with('msg', 'Cập nhật người dùng thành công');
    }

    public function delete(User $user)
    {
    }

    private function getDataUserFromRequest(Request $request)
    {
        $user = new User;

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group_id;
        $user->user_id  = Auth::user()->id;

        return $user;
    }

    private function setSession(Request $request, $key, $value)
    {
        return $request->session()->put($key, $value);
    }

    private function setUserPassword(Request $request, $id)
    {
        $user = User::find($id);
        $requestPassword = $request->password;
        $userPassword = $user->password;
        return $this->hasPasswordFromRequest($request) ? $userPassword :  Hash::make($requestPassword);
    }

    private function hasPasswordFromRequest(Request $request)
    {
        return !empty($request->password);
    }
}