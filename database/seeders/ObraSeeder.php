<?php

namespace Database\Seeders;

use App\Models\Obra;
use Illuminate\Database\Seeder;

class ObraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Obra::factory()->count(5)->create();
    }
}
