<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker=Faker::create('it_IT');
        $services = ['Prima visita','Visita di controllo','Esame strumentale','Terapia'];
        $data=file_get_contents(__DIR__ .'/data/lista_dottori.json');
        $users= json_decode($data,true);
        //dd($users);
        foreach($users as $key=>$user){
            //dd($key,$user);
        
        // dd($vote_ids);
        // $created_array=array('created_at'=>$faker->dateTimebetween('-2 years', '-1 day'),'updated_at'=>Carbon::now());
       
       // dd($created_array);
        $new_user = User::factory()->create([
            'name' => ucwords(strtolower($user['nome'])),
            'email' => strtolower(str_replace(' ', '',$user['nome']).'.'.$user['cognome']).'@bdoctors.com',
            'last_name'=>ucfirst(strtolower($user['cognome'])),
            'password' => '12345678'
        ]);
        
        $new_profile= new Profile;
        $new_profile->user_id= $new_user->id;
        $new_profile->address= $user['address'];
        $new_profile->slug= Str::slug($user['nome'] . '-' .$user['cognome'].'-'. $new_user->id, '-');
        $new_profile->image = 'images/'.$new_profile->slug . '.jpg';
        $new_profile->tel = substr($faker->e164PhoneNumber(), 0 , 13) ;
        $new_profile->services = implode(', ' , $faker->randomElements($services, random_int(1,4)));
        
        $new_profile->save();
        
        $new_profile->specialties()->sync(random_int(1,count(Specialty::all())));

        //inserisco 20 voti per ogni utente
        for ($i=0; $i <20 ; $i++) { 
            //genero un numero random del voto
            $randomVote = random_int(1,5);
            //genero una data random di creazione e di aggiornamento metto quella odierna
            $created_at = $this->randomDate();
            $updated_at = Carbon::now();

            //impattetto tutta la roba insieme
            $argoments_votes = [
                'profile_id' => $new_profile->id,
                'vote_id' => $randomVote,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ];

            //inserisco nella tabella pivot
            DB::table('profile_vote')->insert($argoments_votes);
        }
        
        if ($key < 5){
            $new_profile->sponsorships()->syncWithPivotValues([3], ['expire_date' => Carbon::now()->addDays(6),'current_price'=> 9.99], true);
        }
        
    }
}

    /**
     * Genera una data random tra il 2022 ed oggi e la restituisce
     */
    public function randomDate()
    {   
        //data di inizio: 2022-01-01
        $start = Carbon::createFromDate(2022, 1, 1);
        //data massima : oggi
        $end = Carbon::now();

        //restituisco un valore in mezzo a i due precedenti, quindi tra 2022-01-01 e oggi
        return Carbon::createFromTimestamp(mt_rand($start->timestamp, $end->timestamp));
    }
}
