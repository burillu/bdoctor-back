<?php

namespace App\Http\Controllers\Api;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Vote;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    //METTERE TUTTI I VARI CONTROLLI PER NAME(NAME è UNA STRINGA, LUNGA X, EX. )
    public function index(Request $request)
{
    $specialtyId = $request->query('specialty');
    $name = $request->query('name');
    $minVoteAverage = $request->query('min_vote_average');
    $minVoteNumber = $request->query('min_vote_number');
    $orderByVotes = $request->query('order_by_votes');
    $orderBySponsorshipDuration = $request->query('order_by_sponsorship_duration');
    $orderByReviews = $request->query('order_by_reviews');

    // controlli degli input
    if ($specialtyId && !Specialty::where('id', $specialtyId)->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'La specializzazione specificata non esiste.',
        ]);
    }
    if ($name && preg_match('/\d/', $name)) {
        return response()->json([
            'success' => false,
            'message' => 'Il nome non deve contenere numeri interi.',
        ]);
    }
    if (strlen($name)>255) {
        return response()->json([
            'success' => false,
            'message' => 'Il nome non deve essere più lungo di 255 caratteri',
        ]);
    }
    if ($minVoteAverage && ($minVoteAverage > Vote::max('id') || $minVoteAverage < 0)) {
        return response()->json([
            'success' => false,
            'message' => 'Il valore inserito nella media delle recensioni non è valido',
        ]);
    }

    if ($minVoteNumber &&  $minVoteNumber < 0) {
        return response()->json([
            'success' => false,
            'message' => 'Il valore inserito del numero minimo delle recensioni è minore di 0',
        ]);
    }

    //query per prendere tutti i medici
    $doctorsQuery = Profile::with(['user', 'specialties', 'votes','sponsorships','reviews']);

    if ($orderByVotes) {
        $doctorsQuery->withCount('votes')->orderByDesc('votes_count');
    }
    if ($orderBySponsorshipDuration) {
        $doctorsQuery->leftJoin('sponsorships', 'profiles.id', '=', 'sponsorships.profile_id')
                    ->orderByRaw('CASE WHEN sponsorships.profile_id IS NOT NULL THEN 0 ELSE 1 END')
                     ->orderBy('sponsorships.duration', 'DESC');
    }
    //modifiche alla query in base ai parametri nella request
    if (!empty($name)) {
    $doctorsQuery->whereHas('user', function($query) use ($name) {
        $query->where(function($query) use ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')
                  ->orWhere('last_name', 'LIKE', '%' . $name . '%');
        });
    });
    }

    if (!empty($minVoteAverage)) {
        $doctorsQuery->whereHas('votes', function (Builder $query) use ($minVoteAverage) {
            $query->select(DB::raw('AVG(value) as average'))
                  ->groupBy('profile_id')
                  ->havingRaw('AVG(value) >= ?', [$minVoteAverage]);
        });
    }

    if (!empty($specialtyId)) {
        $doctorsQuery->whereHas('specialties', function($query) use ($specialtyId) {
            $query->where('specialty_id', $specialtyId);
        });
    }

    if (!empty($minVoteNumber)) {
        $doctorsQuery->whereHas('votes', function (Builder $query) use ($minVoteNumber) {
            $query->select(DB::raw('COUNT(value) as count'))
                  ->groupBy('profile_id')
                  ->havingRaw('count(value) >= ?', [$minVoteNumber]);
        });
    }
    if ($orderByReviews) {
        $doctorsQuery->withCount('reviews')->orderByDesc('reviews_count');
    }
    //eseguo la query
    $doctors = $doctorsQuery->get();

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
