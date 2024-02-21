<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;

class DashboardController extends Controller
{
    public function index()
    {
        $gateway = new Gateway(config('services.braintree'));
        // pass $clientToken to your front-end
        //$customerId = Auth::user()->id . Auth::user()->name;
        //dd($customerId);
        $clientToken = $gateway->clientToken()->generate();
        return view('admin.dashboard', compact('clientToken'));
    }
}
