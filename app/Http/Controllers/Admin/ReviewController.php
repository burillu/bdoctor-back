<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(){
       
        
        //$specialties= 
    $review= Review::where('profile_id', Auth::user()->profile->id)->get();

    //$leads= Lead::all();
    //dd($leads);
    return view('admin.reviews.index', compact('review'));
}
public function show(){
    //
}
}
