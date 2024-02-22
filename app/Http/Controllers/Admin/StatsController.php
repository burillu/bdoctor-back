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

        // Riorganizzare i dati nei messaggi per mese e anno
        foreach ($messagesByMonth as $message) {
            $year = $message->year;
            $month = date('F', mktime(0, 0, 0, $message->month, 1));
            $leads[$year][$month] = $message->message_count;
        }

        // Riempire i mesi mancanti con 0
        foreach ($years as $year) {
            if (!isset($leads[$year])) {
                $leads[$year] = array_fill_keys(
                    ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    0
                );
            }else {
                // Se l'anno ha già dei voti, assicurati che tutti i mesi siano presenti e impostali a 0 se mancanti
                foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month) {
                    if (!isset($leads[$year][$month])) {
                        $leads[$year][$month] = 0;
                    }
                }
            }
        }

        //PARTE RECENSIONI SENZA GRAFICO
        // Inizializzare un array per le recensioni per mese e anno
        $reviews = [];

        // Query per ottenere il numero di recensioni per mese e anno
        $reviewsByMonth = Review::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as review_count')
            ->where('profile_id', $profile->id)
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        // Riorganizzare i dati nelle recensioni per mese e anno
        foreach ($reviewsByMonth as $review) {
            $year = $review->year;
            $month = date('F', mktime(0, 0, 0, $review->month, 1));
            $reviews[$year][$month] = $review->review_count;
        }

        // Riempire i mesi mancanti con 0
        foreach ($years as $year) {
            if (!isset($reviews[$year])) {
                $reviews[$year] = array_fill_keys(
                    ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    0
                );
            }else {
                // Se l'anno ha già dei voti, assicurati che tutti i mesi siano presenti e impostali a 0 se mancanti
                foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month) {
                    if (!isset($reviews[$year][$month])) {
                        $reviews[$year][$month] = 0;
                    }
                }
            }
        }

        //PARTE DEI VOTI CON GRAFICO
        // Inizializzare un array per i voti per mese e anno
        $monthsInOrder = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $votes = [];

        // Query per ottenere la media dei voti per mese e anno
        $votesByMonth = Vote::selectRaw('YEAR(votes.created_at) as year, MONTH(votes.created_at) as month, AVG(votes.id) as average_vote')
        ->join('profile_vote', 'votes.id', '=', 'profile_vote.vote_id')
        ->where('profile_vote.profile_id', $profile->id)
        ->groupByRaw('YEAR(votes.created_at), MONTH(votes.created_at)')
        ->get();

        foreach ($years as $year) {
            // Inizializza tutti i mesi dell'anno con il valore 0
            $votes[$year] = array_fill_keys($monthsInOrder, 0);
        
            // Aggiorna i mesi con i valori corrispondenti, se disponibili
            // if (isset($votes[$year])) {
            //     foreach ($monthsInOrder as $month) {
            //         if (!isset($votes[$year][$month])) {
            //             $votes[$year][$month] = 0;
            //         }
            //     }
            // }
        }

        // Riorganizzare i dati nelle recensioni per mese e anno
        foreach ($votesByMonth as $vote) {
            $year = $vote->year;
            $month = date('F', mktime(0, 0, 0, $vote->month, 1));
            $votes[$year][$month] = $vote->average_vote;
        }

        // Riempire i mesi mancanti con la media di 0
        
        // dd($votes);
        // Passare i dati alla vista
        return view('admin.stats.index', compact('clientToken', 'sponsorships', 'years', 'leads', 'reviews', 'votes'));
    }
}
