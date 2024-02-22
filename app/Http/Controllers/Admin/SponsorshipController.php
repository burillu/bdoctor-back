<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSponsorshipRequest;
use App\Http\Requests\UpdateSponsorshipRequest;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;
use Braintree\Gateway;
use App\Models\Profile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile_query = Profile::where('user_id', Auth::id())->with('sponsorships');
        $profile= $profile_query->first();
        //$sponsorshipId=$profile
        $now=Carbon::now();
        //creare una condizione affinche si interrompa la procedura di pagamento se c'è una sponsorship e questa ha un expire_date non ancora passata
        $profile_sponsored= DB::table('profile_sponsorship')
        ->select('expire_date')->where('profile_id', Auth::id())
        ->first();
        $expire_date=$profile_sponsored->expire_date;
        $sponsorships = Sponsorship::all();
        $gateway = new Gateway(config('services.braintree'));
        // pass $clientToken to your front-end
        //$customerId = Auth::user()->id . Auth::user()->name;
        //dd($customerId);
        $clientToken = $gateway->clientToken()->generate();
 // Ritorna la vista con il token del client
 return view('admin.sponsorships.index', compact('clientToken','sponsorships','expire_date','now'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSponsorshipRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSponsorshipRequest $request, Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsorship $sponsorship)
    {
        //
    }
}
