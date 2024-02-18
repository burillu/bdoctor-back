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

       

       return response()->json([
        'success' => true,
        'message' => 'review ok',
        ]);
    }
}
