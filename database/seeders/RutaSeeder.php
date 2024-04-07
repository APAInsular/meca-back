<?php

namespace Database\Seeders;

use App\Models\Ruta;
use Illuminate\Database\Seeder;

class RutaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruta::factory()->count(5)->create();
    }
}
