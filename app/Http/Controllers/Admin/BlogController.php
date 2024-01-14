<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Tag;
use App\Services\BlogService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogController extends Controller
{
    protected $permissionName = 'blog';

    public function __construct()
    {
        $this->implementMethodPermission($this->permissionName);
    }

    public function index()
    {
        $blogList = Blog::all();
        $tags = Tag::orderBy('name')->get()->pluck('name')->toArray();

        return Inertia::render('BlogManagement/Index', [
            'breadcrumb' => readable('manage-blog'),
            'blogList' => $blogList,
            'categories' => blogCategories(),
            'tags' => $tags,
            'userCan' => [
                'massAdd' => false,
                'create' => request()->user('admin')->hasPermissionTo($this->permissionName.'-create'),
                'edit' => request()->user('admin')->hasPermissionTo($this->permissionName.'-edit'),
                'delete' => request()->user('admin')->hasPermissionTo($this->permissionName.'-delete'),
            ],
        ]);
    }

    public function store(StoreBlogRequest $request)
    {
        $request->validated();
        try {
            (new BlogService())->add();
        } catch (\Exception $e) {
            return Redirect::route('manageBlog.index')->with('error', $e->getMessage());
        }

        return Redirect::route('manageBlog.index')->with('success', 'Added Successfully');

    }

    public function update(UpdateBlogRequest $request, $id)
    {
        $request->validated();
        try {
            (new BlogService())->update($id);
        } catch (\Exception $e) {
            return Redirect::route('manageBlog.index')->with('error', $e->getMessage());
        }

        return Redirect::route('manageBlog.index')->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        try {
            (new BlogService())->remove($id);
        } catch (\Exception $e) {
            return Redirect::route('manageBlog.index')->with('error', $e->getMessage());
        }

            return Redirect::route('manageBlog.index')->with('success', 'Deleted Successfully');
    }

    public function deletePicture(int $mediaId)
    {
        try {
            $media = Media::where('id', $mediaId)->first();
            $product = Blog::find($media->model_id);
            $mediaItem = $product->getMedia($media->collection_name)->where('id', $media->id)->first();
            if ($mediaItem) {
                $mediaItem->delete();
            }
        } catch (\Exception $e) {
            return Redirect::route('manageBlog.index')->with('error', $e->getMessage());
        }

        return Redirect::route('manageBlog.index')->with('success', 'Deleted Successfully');
    }
}
