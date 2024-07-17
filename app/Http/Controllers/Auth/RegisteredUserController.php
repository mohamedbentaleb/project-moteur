<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'regex:/^(0)([5-7]{1}[0-9]{8})$/', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone'=>$request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    protected $providers = [ "google", "facebook" ];


    public function redirect($provider)
    {
        // Check if the provider is allowed
        if (in_array($provider, $this->providers)) {
            return Socialite::driver($provider)->redirect();
        }
        abort(404); // Provider not allowed
    }

    public function callback($provider)
    {
        // Check if the provider is allowed
        if (!in_array($provider, $this->providers)) {
            abort(404);
        }

        try {
            $data = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('message', 'Authentication failed');
        }

        // User data
        $id = $data->getId();
        $name = $data->getName() ?? $data->getNickname();
        $email = $data->getEmail();
        $avatar = $data->getAvatar();

        // Check if user already exists
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Create new user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone'=> '',
                'password' => bcrypt('emilie') // Generate a random password
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        // Redirect to home
        return redirect(route('dashboard'));
    }


}
