<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Profile;

class LeadController extends Controller
{
     public function store(Request $request){

        if(!Profile::where('id', $request->profile_id)->exists()){
            return response()->json([
                'success' => false,
                'message' => "l'id del profilo inserito non esiste",
                ]);
        }
        if(strlen($request->name) > 255){
            return response()->json([
                'success' => false,
                'message' => 'il campo nome deve essere inferiore a 255 caratteri',
                ]);
        }
        if(strlen($request->surname) > 255){
            return response()->json([
                'success' => false,
                'message' => 'il campo surname deve essere inferiore a 255 caratteri',
                ]);
        }
        if(strlen($request->email) > 255){
            return response()->json([
                'success' => false,
                'message' => 'il campo email deve essere inferiore a 255 caratteri',
                ]);
        }
        if($request->tel && strlen($request->tel) > 13){
            return response()->json([
                'success' => false,
                'message' => 'il campo tel se presente deve essere inferiore a 255 caratteri',
                ]);
        }
        if(strlen($request->message) > 65535){
            return response()->json([
                'success' => false,
                'message' => 'il campo message deve essere inferiore a 65535 caratteri',
                ]);
        }

        $new_lead= new Lead();
        $new_lead->profile_id = $request->profile_id;
        $new_lead->name= $request->name;
        $new_lead->surname = $request->surname;
        $new_lead->email = $request->email;
        if($new_lead->tel) $new_lead->tel = $request->tel;
        $new_lead->message = $request->message;
        $new_lead->save();

       return response()->json([
        'success' => true,
        'message' => 'leads salvato',
        ]);
    }
}
