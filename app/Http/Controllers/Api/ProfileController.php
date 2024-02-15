<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Vote;
use App\Models\Specialty;

class ProfileController extends Controller
{
    public function index(Request $request)
{
    $specialtyId = $request->query('specialty');
    $voteId = $request->query('vote');
    
    // Controlla se il VOTO E LA SPECIALIZZAZIONE INSIEME richiesti esiste nel database
    if ($voteId && $specialtyId && (!Vote::where('id', $voteId)->exists() && !Specialty::where('id', $specialtyId)->exists())) {
        return response()->json([
            'success' => false,
            'message' => 'Sia l\'ID del voto che quello della specializzazione specificati non esistono.',
        ]);
    }

    // Controlla se il voto richiesto esiste nel database
    if ($voteId && !Vote::where('id', $voteId)->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'Il voto specificato non esiste.',
        ]);
    }

    // Controlla se la specializzazione richiesta esiste nel database
    if ($specialtyId && !Specialty::where('id', $specialtyId)->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'La specializzazione specificata non esiste.',
        ]);
    }

    //query per prendere tutti i medici
    $doctorsQuery = Profile::with(['user', 'specialties', 'votes']);

    //se request è vuota 
    if (empty($specialtyId) && empty($voteId)) {
        //li prende
        $doctors = $doctorsQuery->get();
    } else {
        //nel caso cambio la query in base a ciò che mi richiede il front
        if ($specialtyId && $voteId) {
            $doctorsQuery->whereHas('votes', function($query) use ($voteId) {
                $query->where('vote_id', $voteId);
            })->whereHas('specialties', function($query) use ($specialtyId) {
                $query->where('specialty_id', $specialtyId);
            });
        } elseif ($voteId) {
            $doctorsQuery->whereHas('votes', function($query) use ($voteId) {
                $query->where('vote_id', $voteId);
            });
        } elseif ($specialtyId) {
            $doctorsQuery->whereHas('specialties', function($query) use ($specialtyId) {
                $query->where('specialty_id', $specialtyId);
            });
        }

        //eseguo la query
        $doctors = $doctorsQuery->get();
    }

    return response()->json([
        'success' => true,
        'results' => $doctors,
    ]);
}


    //rimettere email
    public function show($slug)
    {
        $doctor = Profile::with(['user','specialties','votes','sponsorships'])->where('slug', $slug)->first();
        //dd($doctor);
        if ($doctor) {
            
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