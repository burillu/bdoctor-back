<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;
use Braintree\Gateway;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;

class ReviewController extends Controller
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
        $expire_date=$profile_sponsored->expire_date;
       
    $user = Auth::user();
    $data = $user->profile;
    $sponsorships = Sponsorship::all();
     // recensioni in ordine decrescente (per data);
    $reviews= Review::where('profile_id', Auth::user()->profile->id)->orderBy('created_at', 'desc')->get();
    $gateway = new Gateway(config('services.braintree'));
    // pass $clientToken to your front-end
    //$customerId = Auth::user()->id . Auth::user()->name;
    //dd($customerId);
    $clientToken = $gateway->clientToken()->generate();
    //$leads= Lead::all();
    //dd($reviews);
    return view('admin.reviews.index', compact('reviews','user','sponsorships','clientToken','now','expire_date'));
}
public function show(Review $review){
    //
    //dd($review);
    return view('admin.reviews.show', compact('review'));
}
}
