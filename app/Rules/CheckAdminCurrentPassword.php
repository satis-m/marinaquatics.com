<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckAdminCurrentPassword implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the provided value matches the current user's password
        $admin = Auth::guard('admin')->user();

        return Hash::check($value, $admin->password);
    }

    public function message()
    {
        return 'The current password is incorrect.';
    }
}
