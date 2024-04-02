<?php

namespace Database\Seeders;

use App\Models\Logro;
use Illuminate\Database\Seeder;

class LogroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Logro::factory()->count(5)->create();
    }
}
