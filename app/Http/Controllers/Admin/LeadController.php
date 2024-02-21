<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lead;
use App\Models\Sponsorship;
use Braintree\Gateway;

class LeadController extends Controller
{
    public function index(){
    $leads= Lead::where('profile_id', Auth::user()->profile->id)->orderBy('created_at', 'desc')->get();
    $gateway = new Gateway(config('services.braintree'));
    // pass $clientToken to your front-end
    //$customerId = Auth::user()->id . Auth::user()->name;
    //dd($customerId);
    $clientToken = $gateway->clientToken()->generate();
    $sponsorships = Sponsorship::all();
    //dd($leads);
    return view('admin.leads.index', compact('leads', 'sponsorships','clientToken'));
}
    public function show(Lead $lead){
        // dd($lead);
        return view('admin.leads.show', compact('lead'));
    }
}

