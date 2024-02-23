<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;
class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker=Faker::create('it_IT');
        //dd($faker->firstName());
        $reviews_template = [
            "negative"=>[
                    "title" =>[ 'Un macellaio', 'Assolutamente no!', 'Cambia mestiere','Poco professionale', 'Soldi Sprecati','Esperienza negativa','Il peggiore mai conosciuto'],
                    "body" => ['Non è stata per niente una bella esperienza.','Penso di sporgere querela verso questo medico', 'Il problema non è passato, anzi è perggiorato','mi a mandato via ha casa! maledetto nel cuore','Pagliaccio! Medico falso','Non sono per niente felice per quanto accaduto, penso che si debba scusare','Non ho parole, mi ha portato alla crisi di nervi']
            ],
            "positive"=>[
                "title" => ['Consiglio','Competente', 'Il mio problema è risolto. Consiglio','Professionale', 'Miracolo','Assolutamente si!','Merita un premio', 'Dovrebbero essere tutti come lui','Molto paziente'],
                "body" =>['Ho seguito i suoi consigli, mi sento bene. Consiglio assolutamente','Sto meglio','Solo una parola : GRAZIE!','Professionale e con senso dell\'umorismo','la devo ringrazirae d\'avvero.','Non ho trovato nessuno meglio di lui! Da promuovere','Complimenti ancora, ho trovato sollievo dopo la terapia consigliata','È stato come un medico di altri tempi, senza fretta e con tanta passione']
            ]
];
        
        
        //dd($negative);
        //dd($faker->randomElements($reviews_template));

        // $data = file_get_contents(__DIR__ .'/data/reviews.json');
        // $reviews = json_decode($data, true);
        
        for($i=0; $i < 200; $i++){
            $type = $faker->randomElement($reviews_template);
            $new_review= new Review();
            $new_review->profile_id = random_int(1,7);
            $new_review->name= $faker->firstName();
            $new_review->email = strtolower($new_review->name) .'.'.  strtolower(str_replace(' ', '', $faker->lastName())) .'@'. $faker->freeEmailDomain();
            $new_review->title = $faker->randomElement($type['title']);
            $new_review->body = $faker->randomElement($type['body']);
            $new_review->created_at= $faker->dateTimebetween('-2 years', '-1 day');
            $new_review->updated_at= Carbon::now();
            $new_review->save();
            //dd($new_review);
            //$new_review->profile()->sync($new_review->profile_id);
        }
    }
}

