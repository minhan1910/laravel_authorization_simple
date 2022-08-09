<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $list = Groups::all();
        return view('admin.groups.list', compact('list'));
    }

    public function add()
    {
    }

    public function postAdd()
    {
    }

    public function edit(Groups $group)
    {
    }

    public function postEdit(Request $request)
    {
    }

    public function delete()
    {
    }
}