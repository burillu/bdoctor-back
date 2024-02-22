<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //
    public function process(Request $request)
    {
       
        $profile_query = Profile::where('user_id', Auth::id())->with('sponsorships');
        $profile= $profile_query->first();
        //$sponsorshipId=$profile
        //creare una condizione affinche si interrompa la procedura di pagamento se c'è una sponsorship e questa ha un expire_date non ancora passata
        $profile_sponsored= DB::table('profile_sponsorship')
        ->select('expire_date')->where('profile_id', Auth::id())
        ->first();
        //dd($profile_sponsored->expire_date);
        if($profile_sponsored->expire_date > Carbon::now()){
            return redirect()->back()->withInput()->withErrors('Hai una sponsorizzazione già attiva. Al termine del periodo, potrai acquistarne un\' altra.');
        }
        // Inizializza la gateway di Braintree
        $gateway = new Gateway(config('services.braintree'));
        
        //dd($profile);
        

        // Ottiene il nonce del metodo di pagamento dal request e il piano scelto
        $nonce = $request->input('payment_method_nonce');
        $id_plan = $request->input('plan_id');
        if(!$id_plan){
            return redirect()->back()->withInput()->withErrors('Non è stato selezionato alcun piano');
        }

        // Verifica se il nonce è stato fornito
        if (!$nonce) {
            return redirect()->back()->withInput()->withErrors('Il nonce di pagamento non è stato fornito.');
        }
        $amounts = [
            1 => 2.99,
            2 => 5.99,
            3 => 9.99
        ];
        $hours = [
            1=> 24,
            2=> 72,
            3=> 144
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
            $success_message =  'Il pagamento è stato elaborato con successo!';
            // aggiungere al profilo la sponsorizzazione
            //dd(Auth::user()->profile()->sponsorships() );
            $profile->sponsorships()->syncWithPivotValues([$id_plan], ['expire_date' => Carbon::now()->addHours($hours[$id_plan]),'current_price'=> $amount], true);

            return redirect()->route('admin.profile.edit')->with('success_message', $success_message);
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
