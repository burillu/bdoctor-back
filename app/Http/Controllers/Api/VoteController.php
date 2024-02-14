<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;

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
}
