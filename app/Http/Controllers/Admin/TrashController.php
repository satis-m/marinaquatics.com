<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use App\Services\BlogService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class TrashController extends Controller
{
    public function index()
    {
        $trashProduct = Product::onlyTrashed()->get();
        $trashBlog = Blog::onlyTrashed()->get();

        return Inertia::render(
            'Trash/Index',
            [
                'breadcrumb' => readable('trash'),
                'trashProduct' => $trashProduct,
                'trashBlog' => $trashBlog,
            ]
        );
    }

    public function productRestore($productId)
    {
        abort_if(! request()->user('admin')->hasPermissionTo('trash-restore'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            (new ProductService())->restore($productId);
        } catch (\Exception $e) {
            return Redirect::route('trash.index')->with('error', $e->getMessage());
        }

        return Redirect::route('trash.index')->with('success', 'Restored Successfully');
    }

    public function productDestroy($productId)
    {
        abort_if(! request()->user('admin')->hasPermissionTo('trash-destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            (new ProductService())->destroy($productId);
        } catch (\Exception $e) {
            return Redirect::route('trash.index')->with('error', $e->getMessage());
        }

        return Redirect::route('trash.index')->with('success', 'Deleted Successfully');
    }

    public function blogRestore($blogId)
    {
        abort_if(! request()->user('admin')->hasPermissionTo('trash-restore'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            (new BlogService())->restore($blogId);
        } catch (\Exception $e) {
            return Redirect::route('trash.index')->with('error', $e->getMessage());
        }

        return Redirect::route('trash.index')->with('success', 'Restored Successfully');
    }

    public function blogDestroy($blogId)
    {
        abort_if(! request()->user('admin')->hasPermissionTo('trash-destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            (new BlogService())->destroy($blogId);
        } catch (\Exception $e) {
            return Redirect::route('trash.index')->with('error', $e->getMessage());
        }

        return Redirect::route('trash.index')->with('success', 'Deleted Successfully');
    }
}
