<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{

     public function index(){
        $specialties = Specialty::all();
        return response()->json(
            [
                'success' => true,
                'results' => $specialties,
            ]
        );
    }
}
