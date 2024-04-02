<?php

namespace Database\Seeders;

use App\Models\SubLogro;
use Illuminate\Database\Seeder;

class SubLogroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubLogro::factory()->count(5)->create();
    }
}
