<?php

namespace Database\Seeders;

use App\Models\Parada;
use Illuminate\Database\Seeder;

class ParadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parada::factory()->count(5)->create();
    }
}
