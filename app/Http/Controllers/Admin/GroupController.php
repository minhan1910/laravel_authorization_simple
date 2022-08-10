<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\Modules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index()
    {
        $list = Groups::all();
        return view('admin.groups.list', compact('list'));
    }

    public function add()
    {
        return view('admin.groups.add');
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:groups,name',
            ],
            [
                'name.required' => 'Tên không được để trống',
                'name.unique' => 'Tên bị trùng, vui lòng chọn tên khác',
            ]
        );

        $group = new Groups;
        $group->name = $request->name;
        $group->user_id = Auth::user()->id;
        $group->save();

        return redirect()->route('admin.groups.index')->with('msg', 'Thêm nhóm thành công');
    }

    public function edit(Groups $group, Request $request)
    {
        $request->session()->put('groupId', $group->id);
        return view('admin.groups.edit', compact('group'));
    }

    public function postEdit(Request $request)
    {
        $groupId = session('groupId');

        $request->validate(
            [
                'name' => 'required|unique:groups,name,' . $groupId,
            ],
            [
                'name.required' => 'Tên không được để trống',
                'name.unique' => 'Tên bị trùng, vui lòng chọn tên khác',
            ]
        );

        Groups::whereId($groupId)->update(['name' => $request->name]);

        return back()->with('msg', 'Cập nhật người dùng thành công');
    }

    public function delete(Groups $group)
    {
        $userCount = $group->users()->count();

        if ($userCount === 0) {
            Groups::destroy($group->id);
            return redirect()->route('admin.groups.index')->with('msg', 'Xóa nhóm thành công');
        }

        return redirect()->route('admin.groups.index')->with('msg', 'Trong nhóm vẫn còn ' . $userCount . ' người dùng');
    }

    public function permission(Groups $group)
    {
        $modules = Modules::all();

        $roleListArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xóa',
        ];

        $roleJson = $group->permissions;
        if (!empty($roleJson)) {
            $roleArr = json_decode($roleJson, true);
        } else {
            $roleArr = [];
        }

        return view('admin.groups.permission', compact(
            'group',
            'modules',
            'roleListArr',
            'roleArr'
        ));
    }

    public function postPermission(Groups $group, Request $request)
    {
        if (!empty($request->role)) {
            $roleArr = $request->role;
        } else {
            $roleArr = [];
        }

        $roleJson = json_encode($roleArr);

        $group->permissions = $roleJson;
        $group->save();

        return back()->with('msg', 'Phân quyền thành công');
    }
}