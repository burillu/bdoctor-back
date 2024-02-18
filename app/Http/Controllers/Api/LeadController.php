<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends Controller
{
     public function store(Request $request){

        $new_lead= new Lead();
        $new_lead->profile_id = $request->profile_id;
        $new_lead->name= $request->name;
        $new_lead->surname = $request->surname;
        $new_lead->email = $request->email;
        $new_lead->tel = $request->tel ;
        $new_lead->message = $request->message;
        $new_lead->save();

       return response()->json([
        'success' => true,
        'message' => 'leads salvato',
        ]);
    }
}
