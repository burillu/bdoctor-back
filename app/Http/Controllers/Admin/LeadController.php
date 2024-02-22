<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lead;
use App\Models\Sponsorship;
use Braintree\Gateway;
use App\Models\Profile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function index(){
        $profile_query = Profile::where('user_id', Auth::id())->with('sponsorships');
        $profile= $profile_query->first();
        //$sponsorshipId=$profile
        $now=Carbon::now();
        //creare una condizione affinche si interrompa la procedura di pagamento se c'è una sponsorship e questa ha un expire_date non ancora passata
        $profile_sponsored= DB::table('profile_sponsorship')
        ->select('expire_date')->where('profile_id', Auth::id())
        ->first();
        $expire_date=$profile_sponsored?->expire_date;
    $leads= Lead::where('profile_id', Auth::user()->profile->id)->orderBy('created_at', 'desc')->get();
    $gateway = new Gateway(config('services.braintree'));
    // pass $clientToken to your front-end
    //$customerId = Auth::user()->id . Auth::user()->name;
    //dd($customerId);
    $clientToken = $gateway->clientToken()->generate();
    $sponsorships = Sponsorship::all();
    //dd($leads);
    return view('admin.leads.index', compact('leads', 'sponsorships','clientToken','now','expire_date'));
}
    public function show(Lead $lead){
        // dd($lead);
        $profile_query = Profile::where('user_id', Auth::id())->with('sponsorships');
        $profile= $profile_query->first();
        //$sponsorshipId=$profile
        $now=Carbon::now();
        //creare una condizione affinche si interrompa la procedura di pagamento se c'è una sponsorship e questa ha un expire_date non ancora passata
        $profile_sponsored= DB::table('profile_sponsorship')
        ->select('expire_date')->where('profile_id', Auth::id())
        ->first();
        $expire_date=$profile_sponsored?->expire_date;
        $gateway = new Gateway(config('services.braintree'));
    // pass $clientToken to your front-end
    //$customerId = Auth::user()->id . Auth::user()->name;
    //dd($customerId);
    $clientToken = $gateway->clientToken()->generate();
    $sponsorships = Sponsorship::all();
        return view('admin.leads.show', compact('lead','now','expire_date','clientToken','sponsorships'));
    }
}

