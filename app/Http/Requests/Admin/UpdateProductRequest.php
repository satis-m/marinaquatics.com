<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::forUser(auth('admin')->user())->allows('product-edit');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'price' => ['required', 'max:255'],
            'product_info' => ['required'],
        ];
    }
}
