<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BlogService
{
    public function add(): bool
    {
        DB::beginTransaction();
        self::updateTags();

        try {
            $blog = Blog::create([
                'title' => request('title'),
                'body' => request('body'),
                'tag' => ! empty(request('tag')) ? array_map('sanitizer', request('tag')) : '',
                'category' => request('category'),
                'publish' => request('publish'),
            ]);
            if (request()->has('main_picture') && request('main_picture') != null) {
                $blog->addMediaFromRequest('main_picture')->toMediaCollection('blog_main_picture');
            }

            DB::commit();

            return true;
        } catch (QueryException $e) {
            //database related exception
            DB::rollBack();

            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            //general exception
            DB::rollBack();

            return throw new \Exception($e->getMessage());
        }
    }

    public function update($blogId)
    {
        DB::beginTransaction();
        self::updateTags();
        try {
            $product = Blog::find($blogId);
            $product->title = request('title');
            $product->body = request('body');
            $product->tag = request('tag') ? array_map('sanitizer', request('tag')) : '';
            $product->category = request('category');
            $product->publish = request('publish');

            if (request()->has('main_picture') && request('main_picture') != '') {
                $product->addMediaFromRequest('main_picture')->toMediaCollection('blog_main_picture');
            }
            $product->save();
            DB::commit();

            return true;
        } catch (QueryException $e) {
            DB::rollBack();

            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            DB::rollBack();

            return throw new \Exception($e->getMessage());
        }
    }

    private function updateTags(): void
    {
        if (! empty(request('tag'))) {
            $tags = Tag::get()->pluck('name')->toArray();

            $newTags = array_diff(array_map('sanitizer', request('tag')), $tags);

            if (! empty($newTags) || empty($tags)) {
                foreach ($newTags as $tag) {
                    Tag::create(['name' => $tag]);
                }
            }
        }

    }

    public function remove($blogId)
    {
        try {
            return Blog::find($blogId)->delete();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }

    public function destroy($blogId)
    {
        try {
            return Blog::withTrashed()->find($blogId)->forceDelete();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }

    public function restore($blogId)
    {
        try {
            return Blog::withTrashed()->find($blogId)->restore();
        } catch (QueryException $e) {
            return throw new \Exception($e->errorInfo[2]);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }
}
