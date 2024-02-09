<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data=file_get_contents(__DIR__ .'/data/lista_dottori.json');
        $users= json_decode($data,true);
        //dd($users);
        foreach($users as $user){
        $new_user = User::factory()->create([
            'name' => ucwords(strtolower($user['nome'])),
            'email' => strtolower(str_replace(' ', '',$user['nome']).'.'.$user['cognome']).'@bdoctors.com',
            'last_name'=>ucfirst(strtolower($user['cognome'])),
            'password' => '12345678'
        ]);
        
        $new_profile= new Profile;
        $new_profile->user_id= $new_user->id;
        $new_profile->address= $user['address'];
        $new_profile->save();
        
        //per collegare i dati prima bisogna correggere tutti i nomi del model e della tabella specialtie che diventerà speciality

        $new_profile->specialties()->sync(random_int(1,84));
        


    }
}
}
