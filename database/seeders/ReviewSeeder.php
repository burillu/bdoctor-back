<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
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
                    "title" =>[ 'Un macellaio', 'Assolutamente no!', 'Cambia mestiere','Poco professionale', 'Soldi Sprecati'],
                    "body" => ['Non è stata per niente una bella esperienza.','Penso di sporgere querela verso questo medico', 'Il problema non è passato, anzi è perggiorato','mi a mandato via ha casa! maledetto nel cuore','Pagliaccio! Medico falso']
            ],
            "positive"=>[
                "title" => ['Consiglio','Competente', 'Il mio problema è risolto. Consiglio','Professionale', 'Miracolo'],
                "body" =>['Ho seguito i suoi consigli, mi sento bene. Consiglio assolutamente','Sto meglio','Solo una parola : GRAZIE!','Professionale e con senso dell\'umorismo','la devo ringrazirae d\'avvero.']
            ]
];
        
        
        //dd($negative);
        //dd($faker->randomElements($reviews_template));

        // $data = file_get_contents(__DIR__ .'/data/reviews.json');
        // $reviews = json_decode($data, true);
        
        for($i=0; $i < 50; $i++){
            $type = $faker->randomElement($reviews_template);
            $new_review= new Review();
            $new_review->profile_id = random_int(1,7);
            $new_review->name= $faker->firstName();
            $new_review->email = strtolower($new_review->name) .'.'.  strtolower(str_replace(' ', '', $faker->lastName())) .'@'. $faker->freeEmailDomain();
            $new_review->title = $faker->randomElement($type['title']);
            $new_review->body = $faker->randomElement($type['body']);
            $new_review->save();
            //dd($new_review);
            //$new_review->profile()->sync($new_review->profile_id);
        }
    }
}

