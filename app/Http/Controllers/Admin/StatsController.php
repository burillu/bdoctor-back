<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsorship;
use App\Models\User;
use App\Models\Profile;
use App\Models\Vote;
use App\Models\Review;
use App\Models\Lead;
use Braintree\Gateway;

class StatsController extends Controller
{
    public function index()
    {
        //per sponsorships
        $sponsorships = Sponsorship::all();
        $gateway = new Gateway(config('services.braintree'));
        $clientToken = $gateway->clientToken()->generate();

        //per accedere ai dati del giusto utente
        $user = Auth::user();
        $profile = $user->profile;

        //per definire gli anni dei dati nei grafici
        $currentYear = date('Y'); 

        $years = [];
        
        for ($year = 2022; $year <= $currentYear; $year++) {
            $years[] = $year;
        }
        
        $messagesByMonth = Lead::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as message_count')
            ->where('profile_id', $profile->id)
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();
        
        $leads = [];
        
        foreach ($messagesByMonth as $message) {
            $year = $message->year;
            $month = date('F', mktime(0, 0, 0, $message->month, 1));
            $leads[$year][$month] = $message->message_count;
        }
        
        foreach ($years as $year) {
            if (!isset($leads[$year])) {
                $leads[$year] = array_fill_keys(
                    ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    0
                );
            }
        }

        // dati di prova
        // $leads[2023]['January'] = 20;
        // $leads[2023]['February'] = 15;
        // $leads[2023]['March'] = 10;
        // $leads[2023]['April'] = 5;
        // $leads[2023]['June'] = 30;
        // $leads[2023]['September'] = 10;

        // dd($leads);

        return view('admin.stats.index', compact('clientToken','sponsorships','years','leads'));
    }
}