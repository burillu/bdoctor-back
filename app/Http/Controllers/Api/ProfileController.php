<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
        //aggiungere specialties
        //services, curriculum, id 
        public function index(){
            $doctors = Profile::with('user')->get();
            $data = $doctors->map(function ($doctor){
                return[
                    'name' => $doctor->user->name,
                    'last_name'=> $doctor->user->last_name,
                    'address'=> $doctor->address,
                    'id' => $doctor->id,
                    'curriculum' => $doctor->curriculum,
                    'image' => $doctor->image,
                    'tel' => $doctor->tel,
                    'visibility' => $doctor->visibility,
                    'services' => $doctor->services,
                    'slug' => $doctor->slug,
                ];
            });

            return response()->json(
                [
                    'success' => true,
                    'results' => $data,
                ]
            );
        }

    public function show($slug){
        $doctor = Profile::with('user')->where('slug', $slug)->first();
        if($doctor) {
            $data = [
                    'name' => $doctor->user->name,
                    'last_name'=> $doctor->user->last_name,
                    'address'=> $doctor->address,
                    'id' => $doctor->id,
                    'curriculum' => $doctor->curriculum,
                    'image' => $doctor->image,
                    'tel' => $doctor->tel,
                    'visibility' => $doctor->visibility,
                    'services' => $doctor->services,
                    'slug' => $doctor->slug,
            ];

            return response()->json([
                'success' => true,
                'result' => $data,
            ]);

        }else{
            return response()->json([
                'success' => false,
                'result' => 'dottore non trovato',
            ]);
        }
    }
}
