<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request with Rate Limiting.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'ইমেইল অথবা ফোন নম্বর প্রদান করুন।',
            'password.required' => 'পাসওয়ার্ড প্রদান করুন।',
        ]);

        // Rate Limiting: Max 5 attempts per minute per IP + login identity
        $throttleKey = Str::transliterate(Str::lower($request->input('login')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'login' => "অতিরিক্ত ভুল চেষ্টার কারণে লগইন সাময়িকভাবে বন্ধ আছে। দয়া করে {$seconds} সেকেন্ড পর আবার চেষ্টা করুন।",
            ])->onlyInput('login');
        }

        $loginInput = $request->input('login');
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $credentials = [
            $field => $loginInput,
            'password' => $request->input('password'),
        ];
        $remember = $request->boolean('remember');

        // Check user existence and status first
        $user = User::where($field, $loginInput)->first();
        if ($user && $user->status !== 'active') {
            RateLimiter::hit($throttleKey);
            $statusText = $user->status === 'pending' ? 'অপেক্ষমান (Pending)' : 'নিষ্ক্রিয় (Inactive)';
            return back()->withErrors([
                'login' => "আপনার অ্যাকাউন্টটি বর্তমানে {$statusText} অবস্থায় আছে। অনুগ্রহ করে অ্যাডমিনের সাথে যোগাযোগ করুন।",
            ])->onlyInput('login');
        }

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors([
                'login' => 'প্রদত্ত তথ্য আমাদের রেকর্ডের সাথে মিলছে না। সঠিক তথ্য দিন।',
            ])->onlyInput('login');
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'স্বাগতম! আপনি সফলভাবে লগইন করেছেন।');
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^(?:\+8801|01)[3-9]\d{8}$/', 'unique:users,phone'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()->min(6)],
        ], [
            'name.required' => 'আপনার পূর্ণ নাম লিখুন।',
            'email.required' => 'বৈধ ইমেইল ঠিকানা প্রদান করুন।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট প্রদান করুন।',
            'email.unique' => 'এই ইমেইলটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'phone.required' => 'মোবাইল নম্বর প্রদান করুন।',
            'phone.regex' => 'সঠিক বাংলাদেশী মোবাইল নম্বর (যেমন: 017XXXXXXXX) প্রদান করুন।',
            'phone.unique' => 'এই মোবাইল নম্বরটি ইতিমধ্যে নিবন্ধিত আছে।',
            'photo.image' => 'আপলোডকৃত ফাইলটি অবশ্যই ছবি হতে হবে।',
            'photo.mimes' => 'ছবিটি অবশ্যই jpeg, png, jpg বা webp ফরম্যাটে হতে হবে।',
            'photo.max' => 'ছবির সাইজ সর্বোচ্চ ২ মেগাবাইট (2MB) হতে পারবে।',
            'password.required' => 'পাসওয়ার্ড প্রদান করুন।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $photoPath,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        // Assign default Spatie role: member
        $user->assignRole('member');

        Auth::login($user);

        return redirect()->route('home')->with('success', 'অভিনন্দন! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে এবং আপনি সরাসরি লগইন হয়েছেন।');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'আপনি সফলভাবে লগআউট করেছেন।');
    }

    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user via Queue.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'আপনার নিবন্ধিত ইমেইল ঠিকানা দিন।',
            'email.email' => 'সঠিক ইমেইল ফরম্যাট প্রদান করুন।',
        ]);

        $throttleKey = 'forgot-pw|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "খুব ঘনঘন অনুরোধ করা হচ্ছে। অনুগ্রহ করে {$seconds} সেকেন্ড পর আবার চেষ্টা করুন।",
            ]);
        }
        RateLimiter::hit($throttleKey, 60);

        // We use Laravel's Password Broker which calls User::sendPasswordResetNotification
        // and our custom QueuedResetPasswordNotification sends it in the background queue.
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'পাসওয়ার্ড রিসেট লিংকটি আপনার ইমেইলে পাঠানো হয়েছে। অনুগ্রহ করে ইনবক্স অথবা স্প্যাম ফোল্ডার চেক করুন।');
        }

        return back()->withErrors(['email' => 'এই ইমেইল ঠিকানার কোনো ব্যবহারকারী খুঁজে পাওয়া যায়নি।']);
    }

    /**
     * Show the password reset form.
     */
    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()->min(6)],
        ], [
            'token.required' => 'অবৈধ রিসেট টোকেন।',
            'email.required' => 'ইমেইল ঠিকানা আবশ্যক।',
            'password.required' => 'নতুন পাসওয়ার্ড প্রদান করুন।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'আপনার পাসওয়ার্ড সফলভাবে রিসেট হয়েছে। নতুন পাসওয়ার্ড দিয়ে লগইন করুন।');
        }

        return back()->withErrors(['email' => 'পাসওয়ার্ড রিসেট টোকেনটি অবৈধ অথবা মেয়াদোত্তীর্ণ হয়ে গেছে।']);
    }
}
