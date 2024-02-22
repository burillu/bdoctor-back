<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Sponsorship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Specialty;
use Braintree\Gateway;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
/*     public function index()
    {
        $currentUserId = Auth::id();
        $data = Profile::where('user_id', $currentUserId)->first();
        $specialties = Specialty::all();
        //dd($data);
        return view('admin.profile.index', [
            'user' => User::where('id', $currentUserId)->first(),
            'data' => $data,
            'specialties' => $specialties
        ]);

    } */
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        $profile_query = Profile::where('user_id', Auth::id())->with('sponsorships');
        $profile= $profile_query->first();
        //$sponsorshipId=$profile
        //creare una condizione affinche si interrompa la procedura di pagamento se c'è una sponsorship e questa ha un expire_date non ancora passata
        $profile_sponsored= DB::table('profile_sponsorship')
        ->select('expire_date')->where('profile_id', Auth::id())
        ->first();
        $expire_date=$profile_sponsored->expire_date;
        $gateway = new Gateway(config('services.braintree'));
        //dd($gateway);
        // pass $clientToken to your front-end
        //$customerId = Auth::user()->id . Auth::user()->name;
        //dd($customerId);
        $clientToken = $gateway->clientToken()->generate();

        $data= Auth::user()->profile;
        //dd($data);
        //$data = Profile::where('user_id', Auth::user()->id)->first();
        $specialties = Specialty::all();
        //dd(Auth::user);
        $sponsorships = Sponsorship::all();
        return view('admin.profile.edit', [
            'user' => Auth::user(),
            'data' => $data,
            'specialties' => $specialties,
            'clientToken' => $clientToken,
            'sponsorships'=> $sponsorships,
            'expire_date'=>$expire_date,
            'now'=>Carbon::now()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();

        $request->validate([
            'name' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'last_name' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'address' => ['required', 'string', 'max:255'],
            'specialties' => ['required', 'exists:specialties,id'],
            'image' => ['nullable', 'image'],
            'curriculum' => ['nullable', 'file'],
            'tel' => ['nullable', 'unique:profiles,tel,' . $request->user()->profile->id, 'regex:/^[0-9]{10}$/'],
            'services' => ['nullable','max:65535']
        ], [
            'name.required' => 'Il campo nome è obbligatorio.',
            'name.regex' => 'Il campo nome deve essere testuale.',
            'name.max' => 'Il campo nome deve essere lungo massimo :max caratteri.',
            'last_name.required' => 'Il campo cognome è obbligatorio.',
            'last_name.regex' => 'Il campo cognome deve essere testuale.',
            'last_name.max' => 'Il campo cognome deve essere lungo massimo :max caratteri.',            
            'address.required' => 'Il campo indirizzo è obbligatorio.',
            'address.string' => 'Il campo indirizzo deve essere testuale.',
            'address.max' => 'Il campo indirizzo deve essere lungo massimo :max caratteri.',
            'specialties.required' => 'Inserire almeno una specializzazione.',
            'image.image' => 'Inserire un\' immagine in formato \'.jpg.\'',
            'curriculum.file' => 'Inserire un\' file PDF.',
            'tel.unique' => 'Questo numero di telefono esiste già',
            'tel.regex' => 'Inserire un numero di telefono valido',
            'services.max' => 'Il campo dei servizi deve essere lungo massimo :max caratteri.',
        ]);
        $request->user()->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        $request->user()->profile->update([
            'address' => $request->address,
            'services' => $request->services
        ]);

        $visibility = $request->has('visibility') ? 1 : 0;
        // dd($visibility);
        $request->user()->profile->update([
            'visibility' => $visibility,
        ]);

        if ($request->tel) {
            $request->user()->profile->update([
                'tel' => $request->tel,
            ]);
        }
        $request->user()->profile->specialties()->sync($request->specialties);

        if ($request->hasFile('image')) {
            if (Storage::exists("'images/'.$request->user()->profile->id . '.jpg'")) {
                Storage::delete("'images/'.$request->user()->profile->id . '.jpg'");
            }
            $imagePath = $request->file('image')->storeAs('images', $request->user()->profile->id.'.jpg');
            $request->user()->profile->update([
                'image' => $imagePath,
            ]);
        }
        if ($request->hasFile('curriculum')) {
            if (Storage::exists("'curriculums/'.$request->user()->profile->id. '.pdf'")) {
                Storage::delete("'curriculums/'.$request->user()->profile->id. '.pdf'");
            }
            $curriculumPath = $request->file('curriculum')->storeAs('curriculums', $request->user()->profile->id. '.pdf');
            $request->user()->profile->update([
                'curriculum' => $curriculumPath,
            ]);
        }


        return redirect()->route('admin.profile.edit');//, ['profile' => $request->user()->profile])->with('status', 'profile-updated');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}