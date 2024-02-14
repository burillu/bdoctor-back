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
            $doctors = Profile::with('user')->with('specialties')->get();
            $data = $doctors->map(function ($doctor){
                $specialties = [];
                foreach($doctor->specialties as $specialty){
                    array_push($specialties,$specialty->name);
                }
                return[
                    'id' => $doctor->id,
                    'name' => $doctor->user->name,
                    'last_name'=> $doctor->user->last_name,
                    'address'=> $doctor->address,
                    'image' => $doctor->image,
                    'tel' => $doctor->tel,
                    'visibility' => $doctor->visibility,
                    'slug' => $doctor->slug,
                    'spelcieties' => $specialties,
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
        $doctor = Profile::with('user')->with('specialties')->where('slug', $slug)->first();
        if($doctor) {
            $specialties = [];
            foreach($doctor->specialties as $specialty){
                array_push($specialties,$specialty->name);
            }
            $data = [
                    'id' => $doctor->id,
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
                    'spelcieties' => $specialties,
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
