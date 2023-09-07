<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpCodeEmail;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validateWithBag('signUp', [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.Client::class,
            'password' => ['required', 'confirmed'],
        ]);

        $user = Client::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'password' => $request->password,
            'email_verified_at' => Carbon::now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::CLIENTHOME);
    }

    public function otpSend()
    {
        $userEmail = request('email');
        if (Client::where('email', '=', $userEmail)->count() > 0) {
            return 'email-exist';
        }

        $otpCode = otpGenerate(); // You need to implement a function to generate the verification code.
        // Send the email
        Mail::to($userEmail)->send(new OtpCodeEmail($otpCode));
        Session::put($userEmail, $otpCode);

        return 'otp-sent';
    }

    public function otpVerify()
    {
        $userEmail = request('email');
        $userOTP = request('otp');
        $sessionOTP = Session::get($userEmail);

        if ($userOTP == $sessionOTP) {
            return 'otp-verified';
        }

        return 'otp-invalid';
    }
}
