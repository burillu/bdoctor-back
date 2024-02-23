<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lead;

use Illuminate\Support\Carbon;
use Faker\Factory as Faker;
class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker=Faker::create('it_IT');
        //dd($faker->firstName());
        $message='Buongiorno, vorrei un appuntamento per fare una visita specialistica con lei. La ringrazio per l\'attenzione e attendo un suo riscontro. Distinti saluti,  ';


        // $data = file_get_contents(__DIR__ .'/data/leads.json');
        // $leads = json_decode($data, true);
        
        for($i=0; $i < 20; $i++){
            $new_lead= new Lead();
            $new_lead->profile_id = random_int(1,7);
            $new_lead->name= $faker->firstName();
            $new_lead->surname = $faker->lastName();
            $new_lead->email = strtolower($new_lead->name) .'.'.  strtolower(str_replace(' ', '',$new_lead->surname)) .'@'. $faker->freeEmailDomain();
            $new_lead->tel = substr($faker->e164PhoneNumber(), 0 , 13) ;
            $new_lead->message = $message . $new_lead->name .' '.$new_lead->surname;
            $new_lead->created_at= $faker->dateTimebetween('-2 years', '-1 day');
            $new_lead->updated_at= Carbon::now();
            //dd($new_lead);
            $new_lead->save();
            
        }
    }
}
