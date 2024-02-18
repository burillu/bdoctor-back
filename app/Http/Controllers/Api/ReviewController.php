<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Vote;
use App\Models\Profile;

class ReviewController extends Controller
{
     public function store(Request $request){
        
        $new_review= new Review();
        $new_review->profile_id = $request->profile_id;
        if($request->title)$new_review->title= $request->title;
        if($request->body)$new_review->body = $request->body; 
        $new_review->email = $request->email;
        $new_review->name = $request->name;
        $new_review->save();

        $profile_vote = Profile::find($request->profile_id);
        $profile_vote->votes()->attach($request->vote);

        return response()->json([
            'success' => true,
            'message' => 'Recensione salvata con successo',
        ]);
     }
}