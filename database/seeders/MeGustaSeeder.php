<?php

namespace Database\Seeders;

use App\Models\MeGusta;
use Illuminate\Database\Seeder;

class MeGustaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeGusta::factory()->count(5)->create();
    }
}
