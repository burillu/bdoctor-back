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

        $user = Auth::user();
        $profile = $user->profile;

        //per grafico numero di messaggi ricevuti di ogni mese
        $currentYear = now()->year;
        $currentMonth = now()->month;
        //CREARE FUNZIONE PER MESE A ANNO INSERITO
        
        $messagesByMonth = Lead::selectRaw('MONTH(created_at) as month, COUNT(*) as message_count')
    ->where('profile_id', $profile->id)
    ->groupByRaw('MONTH(created_at)')
    ->get();

    $leads = [
        'January' => 0,
        'February' => 0,
        'March' => 0,
        'April' => 0,
        'May' => 0,
        'June' => 0,
        'July' => 0,
        'August' => 0,
        'September' => 0,
        'October' => 0,
        'November' => 0,
        'December' => 0,
    ];

    foreach ($messagesByMonth as $message) {
        $monthName = date('F', mktime(0, 0, 0, $message->month, 1)); 
        $leads[$monthName] = $message->message_count; 
    }       
    // $leads['July'] = 10;
    // dd($leads);

        return view('admin.stats.index', compact('clientToken','sponsorships','leads'));
    }
}
