<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
        foreach($users as $key=>$user){
            //dd($key,$user);
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
        $new_profile->save();
        
        $new_profile->specialties()->sync(random_int(1,count(Specialty::all())));
        $new_profile->votes()->sync([random_int(1,5),random_int(3,5),random_int(1,4)]);
        if ($key < 5){
            $new_profile->sponsorships()->syncWithPivotValues([3], ['expire_date' => Carbon::now()->addDays(6),'current_price'=> 9.99], true);
        }
        
    }
}
}
