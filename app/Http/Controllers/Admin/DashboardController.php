<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;
use App\Models\Sponsorship;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class DashboardController extends Controller
{
    public function index()
    {
        $profile_query = Profile::where('user_id', Auth::id())->with('sponsorships');
        $profile= $profile_query->first();
        $now=Carbon::now();
        //$sponsorshipId=$profile
        //creare una condizione affinche si interrompa la procedura di pagamento se c'è una sponsorship e questa ha un expire_date non ancora passata
        $profile_sponsored= DB::table('profile_sponsorship')
        ->select('expire_date')->where('profile_id', Auth::id())
        ->first();
        $expire_date=$profile_sponsored?->expire_date;
        $gateway = new Gateway(config('services.braintree'));
        // pass $clientToken to your front-end
        //$customerId = Auth::user()->id . Auth::user()->name;
        //dd($customerId);
        $sponsorships = Sponsorship::all();
        $clientToken = $gateway->clientToken()->generate();
        return view('admin.home.index', compact('clientToken', 'sponsorships','now','expire_date'));
    }
}
