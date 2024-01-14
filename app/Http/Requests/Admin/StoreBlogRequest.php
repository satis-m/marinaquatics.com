<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreBlogRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::forUser(auth('admin')->user())->allows('blog-create');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'category' => ['required'],
        ];
    }
}
