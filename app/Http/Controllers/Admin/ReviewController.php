<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(){
       
        
     // recensioni in ordine decrescente (per data);
    $reviews= Review::where('profile_id', Auth::user()->profile->id)->orderBy('created_at', 'desc')->get();

    //$leads= Lead::all();
    //dd($reviews);
    return view('admin.reviews.index', compact('reviews'));
}
public function show(Review $review){
    //
    //dd($review);
    return view('admin.reviews.show', compact('review'));
}
}
