<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\CheckAdminCurrentPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AdminPasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('changePassword', [
            'current_password' => ['required', new CheckAdminCurrentPassword],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        auth('admin')->user()->update([
            'password' => $validated['password'],
        ]);

        return back();
    }
}
