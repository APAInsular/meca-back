<?php

namespace database\seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::factory()->count(100)->create(); // Crear 100 calificaciones utilizando el factory
    }
}
