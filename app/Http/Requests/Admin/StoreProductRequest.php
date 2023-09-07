<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::forUser(auth('admin')->user())->allows('product-create');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'price' => ['required', 'max:255'],
            'product_info' => ['required'],
            'category' => ['required'],
            'sub_category' => ['required'],
            'type' => ['required'],
            'unit' => ['required'],
        ];
    }
}
