<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = file_get_contents(__DIR__ . "/data/lista_sponsorship.json");
        $dataArray = json_decode($data, true);
        foreach ($dataArray as $sponsorship) {
            $new_sponsorship = new Sponsorship();
            $new_sponsorship->name = $sponsorship["name"];
            $new_sponsorship->price = $sponsorship["price"];
            $new_sponsorship->duration = $sponsorship["duration"];
        }
    }
}
