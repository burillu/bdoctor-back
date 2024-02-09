<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = ['dermatologo','cardiologo','tricologo'];
        foreach($specialties as $value){
            $newSpecialty = new Specialty();
            $newSpecialty->name=$value;
            $newSpecialty->save();
        }
    }
}
