<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;


class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        // Validate provider
        if (!in_array($provider, ['facebook', 'google'])) {
            return redirect()->route('login')->with('error', 'Invalid provider.');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        // Validate provider
        if (!in_array($provider, ['facebook', 'google'])) {
            return redirect()->route('login')->with('error', 'Invalid provider.');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::updateOrCreate(
                [
                    $provider . '_id' => $socialUser->id,
                ],
                [
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'provider_name' => $provider,
                    $provider . '_id' => $socialUser->id,
                    'email_verified_at' => now(),
                    'password' => Str::random(16),
                ]
            );

            // Assign 'students' role to new users
            if (!$user->wasRecentlyCreated) {
                $user->update([
                    'provider_name' => $provider,
                ]);
            } else {
                $studentRole = Role::firstOrCreate(
                    ['name' => 'students'],
                    ['guard_name' => 'web']
                );
                $user->assignRole($studentRole);
            }

            Auth::login($user, true);
            return redirect()->route('home');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Social login failed, please try again.');
        }
    }
}
