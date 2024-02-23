<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsorship;
use App\Models\Review;
use App\Models\Lead;
use App\Models\Vote;
use Braintree\Gateway;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // Ottenere sponsorships e il token del client per Braintree
        $sponsorships = Sponsorship::all();
        $gateway = new Gateway(config('services.braintree'));
        $clientToken = $gateway->clientToken()->generate();

        // Ottenere l'utente e il suo profilo
        $user = Auth::user();
        $profile = $user->profile;

        // Ottenere l'anno corrente
        $currentYear = date('Y');
        //mesi in ordine
        $monthsInOrder = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        //PARTE MESSAGGI SENZA GRAFICO
        // Creare un array di anni da 2022 fino all'anno corrente
        $years = range(2022, $currentYear);

        // Inizializzare un array per i messaggi ricevuti per mese e anno
        $leads = [];

        // Query per ottenere il numero di messaggi ricevuti per mese e anno
        $messagesByMonth = Lead::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as message_count')
            ->where('profile_id', $profile->id)
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
        ->get();

        foreach ($years as $year) {
            foreach ($monthsInOrder as $month) {
                $leads[$year][$month] = 0;
            }
        }

        // Riorganizzare i dati nei messaggi per mese e anno
        foreach ($messagesByMonth as $message) {
            $year = $message->year;
            $month = date('F', mktime(0, 0, 0, $message->month, 1));
            $leads[$year][$month] = $message->message_count;
        }

        //PARTE RECENSIONI SENZA GRAFICO
        // Inizializzare un array per le recensioni per mese e anno
        $reviews = [];

        // Query per ottenere il numero di recensioni per mese e anno
        $reviewsByMonth = Review::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as review_count')
            ->where('profile_id', $profile->id)
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
        ->get();

        foreach ($years as $year) {
            foreach ($monthsInOrder as $month) {
                $reviews[$year][$month] = 0;
            }
        }

        // Riorganizzare i dati nelle recensioni per mese e anno
        foreach ($reviewsByMonth as $review) {
            $year = $review->year;
            $month = date('F', mktime(0, 0, 0, $review->month, 1));
            $reviews[$year][$month] = $review->review_count;
        }

        //PARTE DEI VOTI CON GRAFICO
        // Inizializzare un array per i voti per mese e anno
        $votes = [];

        // Query per ottenere la media dei voti per mese e anno
        for ($year = 2022; $year <= $currentYear; $year++) {
            // Esegui la query per ottenere la media dei voti per l'anno e il mese correnti
            for ($month = 1; $month <= 12; $month++) {  
                $averageVote = Vote::selectRaw('AVG(votes.value) as average_vote')
                    ->join('profile_vote', 'votes.id', '=', 'profile_vote.vote_id')
                    ->where('profile_vote.profile_id', $profile->id)
                    ->whereRaw('YEAR(profile_vote.created_at) = ?', [$year])
                    ->whereRaw('MONTH(profile_vote.created_at) = ?', [$month])
                    ->first();

                // Se esiste un risultato, salva la media dei voti per quell'anno e mese
                if ($averageVote !== null) {
                    $votes[$year][$monthsInOrder[$month - 1]] = $averageVote->average_vote;
                } else {
                    // Altrimenti, imposta la media dei voti a 0
                    $votes[$year][$monthsInOrder[$month - 1]] = 0;
                }
            }
        }
        
        // dd($votes);
        return view('admin.stats.index', compact('clientToken', 'sponsorships', 'years', 'leads', 'reviews', 'votes'));
    }
}
