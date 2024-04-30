<?php

namespace Database\Seeders;

use App\Models\Monument;
use Illuminate\Database\Seeder;

class MonumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Monument::factory()->count(5)->create();
    }
}
