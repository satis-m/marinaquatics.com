<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        $blogList = Blog::all();

        return Inertia::render('BlogManagement/Index', [
            'breadcrumb' => readable('manage-blog'),
            'blogList' => $blogList,
            'userCan' => [
                'massAdd' => false,
                'create' => true, //request()->user('admin')->hasPermissionTo($this->permissionName.'-create'),
                'edit' => true, //request()->user('admin')->hasPermissionTo($this->permissionName.'-edit'),
                'delete' => true, //request()->user('admin')->hasPermissionTo($this->permissionName.'-delete'),
            ],
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
