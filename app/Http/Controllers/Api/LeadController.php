<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Profile;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class LeadController extends Controller
{
     public function store(Request $request){

        if(!$request->profile_id){
            return response()->json([
                'success' => false,
                'message' => 'il campo profile_id è obbligatorio',
                ]);
        }
        if(!Profile::where('id', $request->profile_id)->exists()){
            return response()->json([
                'success' => false,
                'message' => "l'id del profilo inserito non esiste",
                ]);
        }
        if(!$request->name){
            return response()->json([
                'success' => false,
                'message' => 'il campo name è obbligatorio',
                ]);
        }
        if(strlen($request->name) > 255){
            return response()->json([
                'success' => false,
                'message' => 'il campo name deve essere inferiore a 255 caratteri',
                ]);
        }
        if(!preg_match('/^[a-zA-Z\s]+$/', $request->name)){
            return response()->json([
                'success' => false,
                'message' => 'il campo name deve essere testuale',
                ]);
        }
        if(!$request->surname){
            return response()->json([
                'success' => false,
                'message' => 'il campo surname è obbligatorio',
                ]);
        }
        if(strlen($request->surname) > 255){
            return response()->json([
                'success' => false,
                'message' => 'il campo surname deve essere inferiore a 255 caratteri',
                ]);
        }
        if(!preg_match('/^[a-zA-Z\s]+$/', $request->surname)){
            return response()->json([
                'success' => false,
                'message' => 'il campo surname deve essere testuale',
                ]);
        }
        if(!$request->email){
            return response()->json([
                'success' => false,
                'message' => 'il campo email è obbligatorio',
                ]);
        }
        if(strlen($request->email) > 255){
            return response()->json([
                'success' => false,
                'message' => 'il campo email deve essere inferiore a 255 caratteri',
                ]);
        }
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return response()->json([
                'success' => false,
                'message' => 'il campo email deve essere una email valida',
                ]);
        }
        // if($request->tel && strlen($request->tel) > 13){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'il campo tel se presente deve essere inferiore a 13 caratteri',
        //         ]);
        // }
        if ($request->tel && !preg_match('/^\+?\d{5,13}$/', $request->tel)) {
            return response()->json([
                'success' => false,
                'message' => 'Il campo tel deve essere un numero di telefono valido.',
            ]);
        }
        if(!$request->message){
            return response()->json([
                'success' => false,
                'message' => 'il campo message è obbligatorio',
                ]);
        }
        if(strlen($request->message) > 65535){
            return response()->json([
                'success' => false,
                'message' => 'il campo message deve essere inferiore a 65535 caratteri',
                ]);
        }
$now = Carbon::now();
        $new_lead= new Lead();
        $new_lead->profile_id = $request->profile_id;
        $new_lead->name= $request->name;
        $new_lead->surname = $request->surname;
        $new_lead->email = $request->email;
        if($request->tel) $new_lead->tel = $request->tel;
        $new_lead->message = $request->message;
        $new_lead->created_at= $now;
        $new_lead->updated_at = $now;
        $new_lead->save();

       return response()->json([
        'success' => true,
        'message' => 'leads salvato',
        ]);
    }
}
