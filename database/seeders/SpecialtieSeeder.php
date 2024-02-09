<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Specialtie;

class SpecialtieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = ['dermatologo','cardiologo','tricologo'];
        foreach($specialties as $value){
            $newSpecialtie = new Specialtie();
            $newSpecialtie->name=$value;
            $newSpecialtie->save();
        }
    }
}
