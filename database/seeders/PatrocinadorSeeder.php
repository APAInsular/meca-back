<?php

namespace Database\Seeders;

use App\Models\Patrocinador;
use Illuminate\Database\Seeder;

class PatrocinadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patrocinador::factory()->count(5)->create();
    }
}
