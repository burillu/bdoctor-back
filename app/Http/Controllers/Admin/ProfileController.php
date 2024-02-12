<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Specialty;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $data = Profile::where('user_id', $request->user()->id)->first();
        $specialties = Specialty::all();
        //dd($data);
        return view('admin.profile.edit', [
            'user' => $request->user(),
            'data' => $data,
            'specialties' => $specialties
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
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'address' => ['required', 'string', 'max:255'],
            'specialties' => ['required', 'exists:specialties,id'],
            'image' => ['nullable', 'image'],
            'curriculum' => ['nullable', 'file'],
            'tel' => ['nullable', 'unique:profiles,tel,' . $request->user()->profile->id, 'regex:/^[0-9]{10}$/'],
        ], [
            'name.required' => 'Il campo nome è obbligatorio.',
            'name.string' => 'Il campo nome deve essere testuale.',
            'name.max' => 'Il campo nome deve essere lungo massimo :max caratteri.',
            'last_name.required' => 'Il campo cognome è obbligatorio.',
            'last_name.string' => 'Il campo cognome deve essere testuale.',
            'last_name.max' => 'Il campo cognome deve essere lungo massimo :max caratteri.',
            'email.required' => 'Il campo email è obbligatorio.',
            'email.string' => 'Il campo email deve essere testuale.',
            'email.max' => 'Il campo email deve essere lungo massimo :max caratteri.',
            'email.email' => "Il campo email deve essere un'email valida.",
            'email.unique' => 'L\'indirizzo email è già utilizzato.',
            'address.required' => 'Il campo indirizzo è obbligatorio.',
            'address.string' => 'Il campo indirizzo deve essere testuale.',
            'address.max' => 'Il campo indirizzo deve essere lungo massimo :max caratteri.',
            'specialties.required' => 'Inserire almeno una specializzazione.',
            'image.image' => 'Inserire un\' immagine.',
            'curriculum.file' => 'Inserire un\' file PDF.',
            'tel.unique' => 'Questo numero di telefono esiste già',
            'tel.regex' => 'Inserire un numero di telefono valido'
        ]);
        $request->user()->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        $request->user()->profile->update([
            'address' => $request->address,
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
            if (Storage::exists("'images/'.$request->user()->profile->slug . '.jpg'")) {
                Storage::delete("'images/'.$request->user()->profile->slug . '.jpg'");
            }
            $imagePath = $request->file('image')->storeAs('images', $request->user()->profile->slug.'.jpg');
            $request->user()->profile->update([
                'image' => $imagePath,
            ]);
        }
        if ($request->hasFile('curriculum')) {
            if (Storage::exists("'curriculums/'.$request->user()->profile->slug. '.pdf'")) {
                Storage::delete("'curriculums/'.$request->user()->profile->slug. '.pdf'");
            }
            $curriculumPath = $request->file('curriculum')->storeAs('curriculums', $request->user()->profile->slug. '.pdf');
            $request->user()->profile->update([
                'curriculum' => $curriculumPath,
            ]);
        }

        return redirect()->route('admin.profile.edit', ['profile' => $request->user()->profile])->with('status', 'profile-updated');
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
