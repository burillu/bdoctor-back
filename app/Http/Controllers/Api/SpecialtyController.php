<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{

     public function index(){
        $specialties = Specialty::all();
        $data = $specialties->map(function ($specialty){
            return[
                'name' => $specialty->name,
                'id' => $specialty->id,
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
