<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{

        public function index(){
            $dottori = Profile::all();
            return response()->json(
                [
                    'success' => true,
                    'results' => $dottori,
                ]
            );
    }
    public function show($id){
        $dottori = Profile::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'result' => $dottori
        ]);
    }
}
