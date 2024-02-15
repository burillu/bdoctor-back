<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('specialty') && $request->query('vote')) {
            $voteId = $request->query('vote');
            $specialtyId = $request->query('specialty');
        
            $doctors = Profile::with(['user', 'specialties', 'votes'])
        ->whereHas('votes', function($query) use ($voteId) {
            $query->where('vote_id', $voteId);
        })
        ->whereHas('specialties', function($query) use ($specialtyId) {
            $query->where('specialty_id', $specialtyId);
        })
        ->get();

            return response()->json([
                'success' => true,
                'results' => $doctors,
            ]);
        }
        elseif($request->query('vote')){
            $voteId = $request->query('vote');
            $doctors = Profile::with(['user','specialties','votes'])
                ->whereHas('votes', function($query) use ($voteId) {
                $query->where('vote_id', $voteId);
            })
            ->get();
            
            return response()->json([
            'success' => true,
            'results' => $doctors,
            ]);
        }
        elseif($request->query('specialty')){
            $specialtyId = $request->query('specialty');
            $doctors = Profile::with(['user','specialties','votes'])
                ->whereHas('specialties', function($query) use ($specialtyId) {
                $query->where('specialty_id', $specialtyId);
            })
            ->get();
            
            return response()->json([
            'success' => true,
            'results' => $doctors,
            ]);
        }
        
        else{
            $doctors = Profile::with(['user','specialties','votes'])->get();
            // $data = $doctors->map(function ($doctor) {
            //     $specialties = $this->specialtiesNames($doctor);
            //     $vote_average = $this->voteAverageCalculate($doctor);
            //     return [
            //         'id' => $doctor->id,
            //         'name' => $doctor->user->name,
            //         'last_name' => $doctor->user->last_name,
            //         'address' => $doctor->address,
            //         'image' => $doctor->image,
            //         'tel' => $doctor->tel,
            //         'visibility' => $doctor->visibility,
            //         'slug' => $doctor->slug,
            //         'specialties' => $specialties,
            //         'vote_average' =>  number_format((float)$vote_average, 2, '.', ''),
            //     ];
            // });

            return response()->json([
                'success' => true,
                'results' => $doctors //$data,
            ]);
        }
        
    }

    //rimettere email
    public function show($slug)
    {
        $doctor = Profile::with(['user','specialties','votes','sponsorships'])->where('slug', $slug)->first();
        //dd($doctor);
        if ($doctor) {
            // $vote_average = $this->voteAverageCalculate($doctor);
            // $specialties = $this->specialtiesNames($doctor);
            // $data = [
            //     'id' => $doctor->id,
            //     'name' => $doctor->user->name,
            //     'last_name' => $doctor->user->last_name,
            //     'address' => $doctor->address,
            //     'curriculum' => $doctor->curriculum,
            //     'image' => $doctor->image,
            //     'tel' => $doctor->tel,
            //     'visibility' => $doctor->visibility,
            //     'services' => $doctor->services,
            //     'slug' => $doctor->slug,
            //     'specialties' => $specialties, 
            //     // 'sponsorship' => $doctor->sponsorships,
            //     'vote_average' =>  number_format((float)$vote_average, 2, '.', ''),
            // ];
            return response()->json([
                'success' => true,
                'result' => $doctor,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'result' => 'Dottore non trovato',
            ]);
        }
    }

    /**
     * preso il parametro $doctor, cicla le specialties e ne prende solo in nome, e restituisce l'array pieno
     */
    public function specialtiesNames($doctor)
    {
        $specialties = [];
        foreach ($doctor->specialties as $specialty) {
            array_push($specialties, $specialty->name);
        }
        return $specialties;
    }

    /**
     * preso il parametro $doctor, cicla i voti ricevuti (se ne ha ricevuti), li somma ed infine li divide per il numero di valori, ritorna il valore corretto o lo 0 nel caso non ci siano voti ricevuti
     */
    public function voteAverageCalculate($doctor){
        $vote_average = 0;
            if(count($doctor->votes) >= 1){
                foreach ($doctor->votes as $vote) {
                    $vote_average += $vote->value;
                }
                $vote_average /= count( $doctor->votes);
            }
        return $vote_average;
    }
}
