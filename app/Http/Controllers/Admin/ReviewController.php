<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;
use Braintree\Gateway;

class ReviewController extends Controller
{
    public function index(){
       
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
    return view('admin.reviews.index', compact('reviews','user','sponsorships','clientToken'));
}
public function show(Review $review){
    //
    //dd($review);
    return view('admin.reviews.show', compact('review'));
}
}
