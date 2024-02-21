<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;

class PaymentController extends Controller
{
    public function index()
    {
        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);

        $token = $gateway->ClientToken()->generate();

        return view('admin.payments.index', ['token' => $token]);
    }

    public function handlePayment(Request $request)
    {
        $nonce = $request->input('nonce');

        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);

        $status = $gateway->transaction()->sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($status->success) {
            // Transazione completata con successo
            // Puoi fare ulteriori operazioni qui, ad esempio salvare la transazione nel database

            return response()->json(['success' => true]);
        } else {
            // Transazione fallita
            $errorMessage = $status->message;

            return response()->json(['success' => false, 'message' => $errorMessage]);
        }
    }
}
