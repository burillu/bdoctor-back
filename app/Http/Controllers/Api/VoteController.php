<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Profile;

class VoteController extends Controller
{
     public function index(){
        $votes = Vote::all();
        $data = $votes->map(function ($vote){
            return[
                'value' => $vote->value,
            ];
        });
        return response()->json(
            [
                'success' => true,
                'results' => $data,
            ]
        );
    }

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
        if(!$request->vote_id){
            return response()->json([
                'success' => false,
                'message' => 'il campo vote_id è obbligatorio',
                ]);
        }
        if(!Vote::where('id', $request->vote_id)->exists()){
            return response()->json([
                'success' => false,
                'message' => "l'id del voto inserito non esiste",
                ]);
        }

        $profile_vote = Profile::find($request->profile_id);
        $profile_vote->votes()->attach($request->vote_id);

        return response()->json([
            'success' => true,
            'message' => 'Voto salvato con successo',
        ]);
    }
}
