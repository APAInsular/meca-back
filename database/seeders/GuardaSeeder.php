<?php

namespace Database\Seeders;

use App\Models\Guarda;
use Illuminate\Database\Seeder;

class GuardaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guarda::factory()->count(5)->create();
    }
}
