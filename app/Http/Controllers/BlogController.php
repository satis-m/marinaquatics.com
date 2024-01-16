<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index($category = 'all')
    {
        try {
            $blogsQuery = Blog::query()
                ->when($category != 'all', function ($query) use ($category) {
                    $query->where('category', $category);
                });
            $data['blogList'] = $blogsQuery->published()
                ->paginate(12)
                ->appends(request()->query());

            $data['blogCountsByCategory'] = Blog::published()
                ->groupBy('category')
                ->selectRaw('category, COUNT( * ) as count')
                ->pluck('count', 'category')
                ->toArray();
            $data['blogAllCount'] = Blog::published()->get()->count();
            $data['blogCategories'] = blogCategories();
            //meta for seo of singel product

            return Inertia::render('Blog/CategoryView/Index', $data);
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Blog not found');
        }
    }

    public function view($slug)
    {
        try {
            $blogInfo = Blog::query()
                ->where('slug', $slug)
                ->published()
                ->firstOrFail();

            $data['blogInfo'] = $blogInfo;
            //meta for seo of singel product
            $meta['og_meta'] = [
                'og_title' => $blogInfo->title,
                'og_description' => Str::limit($blogInfo->body, 100),
                'og_image' => $blogInfo->main_picture['preview'],
                'og_url' => url()->current(),
            ];
            $data['previousBlog'] = $data['nextBlog'] = null;

            $data['previousBlog'] = DB::table('blogs')
                ->where('id', '<', $blogInfo->id)
                ->where('publish', 1)
                ->orderBy('id', 'desc')
                ->first(['title', 'slug']);
            $data['nextBlog'] = DB::table('blogs')
                ->where('id', '>', $blogInfo->id)
                ->where('publish', 1)
                ->orderBy('id', 'asc')
                ->first(['title', 'slug']);

            return Inertia::render('Blog/SingleView/Index', $data)->withViewData($meta);
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Blog not found');
        }
    }
}
