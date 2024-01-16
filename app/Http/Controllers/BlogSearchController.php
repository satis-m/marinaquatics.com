<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class BlogSearchController extends Controller
{
    public function __invoke()
    {
        try {
            $blogsQuery = Blog::query()
                ->when(request('search'), function ($query, $search) {
                    $query->search($search);
                });
            $data['blogList'] = $blogsQuery->published()
                ->paginate(12)
                ->appends(request()->query());

            $data['blogCountsByCategory'] = Blog::published()
                ->groupBy('category')
                ->selectRaw('category, COUNT(*) as count')
                ->pluck('count', 'category')
                ->toArray();
            $data['blogAllCount'] = Blog::published()
                ->get()
                ->count();
            $data['blogCategories'] = blogCategories();
            $data['filters'] = request()->only('search');
            //meta for seo of singel product
            return Inertia::render('Blog/SearchView/Index', $data);
        } catch (ModelNotFoundException $exception) {
            // Product not found, handle the exception or return an error response
            // For example:
            abort(404, 'Blog not found');
        }
    }
}
