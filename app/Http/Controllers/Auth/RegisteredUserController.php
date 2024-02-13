<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

use App\Models\Specialty;

use App\Models\Profile;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $specialties = Specialty::all();
        return view('auth.register',compact('specialties'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request);
        $request->validate([
            'name' => ['required', 'alpha:ascii', 'max:255'],
            'last_name' => ['required', 'alpha:ascii', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed','min:8', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'min:8'],
            'specialties' => ['required', 'exists:specialties,id'],
        ], [
            'name.required'=>'Questo campo è obbligatorio',
            'name.alpha'=>'Questo campo deve essere testuale',
            'name.max'=>'Questo può essere lungo massimo :max caratteri',
            'last_name.required'=>'Questo campo è obbligatorio',
            'last_name.alpha'=>'Questo campo deve essere testuale',
            'last_name.max'=>'Questo può essere lungo massimo :max caratteri',
            'email.required'=>'Questo campo è obbligatorio',
            'email.string'=>'Questo campo deve essere una stringa di testo',
            'email.max'=>'Questo può essere lungo massimo :max caratteri',
            'email.lowercase'=>'Questo campo deve essere scritto in minuscolo',
            'email.unique'=>'Questa email esiste già',
            'address.required'=>'Questo campo è obbligatorio',
            'address.string'=>'Questo campo deve essere una stringa di testo',
            'address.max'=>'Questo può essere lungo massimo :max caratteri',
            'password.required'=>'Questo campo è obbligatorio',
            'password.min'=>'Questo campo deve essere lungo almeno :min caratteri',
            'password.confirmed'=>'password non corrisponde alla conferma',
            'password_confirmation.required'=>'questo campo è obbligatorio',
            'password_confirmation.min'=>'Questo campo deve essere lungo almeno :min caratteri',
            'password_confirmation.confirmed'=>'',
            'specialties.required' => 'Inserire almeno un valore.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if($user){
             $profile=Profile::create([
            'address' => $request->address,
            'slug'=> Str::slug($request->name . '-' .$request->last_name, '-'),
            'user_id' => $user->id,
        ]);
        }
       

        $profile->specialties()->attach($request->specialties);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
