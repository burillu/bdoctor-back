<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;

class PaymentController extends Controller
{
    public function show(Request $request)
    {
        // Inizializza la gateway di Braintree
        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key'),
        ]);

        // Genera un token del client per il Drop-in UI di Braintree
        $clientToken = $gateway->clientToken()->generate();

        $sponsorshipId = $request->id;

        // Ritorna la vista con il token del client
        return view('admin.payments.payment', compact('clientToken','sponsorshipId'));
    }

    public function process(Request $request)
    {
        // Inizializza la gateway di Braintree
        $gateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key'),
        ]);

        // Ottiene il nonce del metodo di pagamento dal request e il piano scelto
        $nonce = $request->input('payment_method_nonce');
        $id_plan = $request->input('plan_id');

        // Verifica se il nonce è stato fornito
        if (!$nonce) {
            return redirect()->back()->withInput()->withErrors('Il nonce di pagamento non è stato fornito.');
        }
        $amounts = [
            1 => 10.00,
            2 => 20.00,
            3 => 30.00
        ];
        
        $amount = $amounts[$id_plan] ?? null;
        // Esegui il pagamento utilizzando il nonce ottenuto e l'importo
        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        // Verifica se il pagamento è stato elaborato con successo
        if ($result->success) {
            return redirect()->route('payment.confirmation')->with('success_message', 'Il pagamento è stato elaborato con successo!');
        } else {
            // Il pagamento ha fallito, gestisci l'errore di conseguenza
            $errorMessages = [];
            foreach ($result->errors->deepAll() as $error) {
                $errorMessages[] = $error->message;
            }
            return redirect()->back()->withInput()->withErrors($errorMessages);
        }
    }
}
