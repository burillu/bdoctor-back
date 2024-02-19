<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lead;
//use App\Models\Profile;

class LeadController extends Controller
{
    public function index(){
       
        
        //$specialties= 
    $leads= Lead::where('profile_id', Auth::user()->profile->id)->get();
    //$leads= Lead::all();
    //dd($leads);
    return view('admin.leads.index', compact('leads'));
}
public function show(){
    //
}
}

