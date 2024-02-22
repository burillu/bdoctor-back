<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsorship;
use Braintree\Gateway;

class StatsController extends Controller
{
    public function index()
    {
        $sponsorships = Sponsorship::all();
        $gateway = new Gateway(config('services.braintree'));
        $clientToken = $gateway->clientToken()->generate();

        return view('admin.stats.index', compact('clientToken','sponsorships'));
    }
}
