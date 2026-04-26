<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider's authentication page.
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        session()->put('socialite_provider', $provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from the provider.
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            Log::error('Socialite callback failed', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => "Authentication with " . ucfirst($provider) . " failed. Please try again.",
            ]);
        }

        // Ensure we have an email
        $email = $socialUser->getEmail();
        if (! $email) {
            return redirect()->route('login')->withErrors([
                'email' => "Your " . ucfirst($provider) . " account does not have an email address associated with it.",
            ]);
        }

        // Check if a user already exists with this provider and provider ID
        $user = User::where('auth_provider', $provider)
            ->where('auth_provider_id', $socialUser->getId())
            ->first();

        if ($user) {
            // User exists — log them in
            Auth::login($user);

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Check if a user already exists with this email
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            // Link the provider to the existing account
            $existingUser->update([
                'auth_provider' => $provider,
                'auth_provider_id' => $socialUser->getId(),
            ]);

            Auth::login($existingUser);

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Create a new user
        $name = $socialUser->getName() ?? $socialUser->getNickname() ?? explode('@', $email)[0];

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(Str::password(32)), // Random password since social login
            'auth_provider' => $provider,
            'auth_provider_id' => $socialUser->getId(),
        ]);

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Validate that the given provider is supported.
     */
    protected function validateProvider(string $provider): void
    {
        if (! in_array($provider, ['google', 'facebook', 'microsoft'])) {
            abort(404, 'Unsupported authentication provider.');
        }
    }
}
