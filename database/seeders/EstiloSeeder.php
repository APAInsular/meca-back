<?php

namespace Database\Seeders;

use App\Models\Estilo;
use Illuminate\Database\Seeder;

class EstiloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estilo::factory()->count(5)->create();
    }
}
