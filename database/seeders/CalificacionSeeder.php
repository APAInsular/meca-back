<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use Illuminate\Database\Seeder;

class CalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Calificacion::factory()->count(5)->create();
    }
}
