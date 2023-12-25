<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    public function index(): Response
    {
        Session::put('intended_url', url()->previous());

        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        Auth::guard('admin')->logout(); //invalidate admin session

        $request->session()->regenerate();
        $intendedUrl = Session::get('intended_url');
        if ($intendedUrl) {
            Session::forget('intended_url');

            if (auth('client')->user()->status === 'blocked') {
                auth('client')->logout();
                throw ValidationException::withMessages([
                    'email' => 'Your account has been blocked by the admin.',
                ])->errorBag('login');
            }
            return redirect($intendedUrl);
        }

        return redirect()->intended(RouteServiceProvider::CLIENTHOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
