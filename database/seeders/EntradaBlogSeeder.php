<?php

namespace Database\Seeders;

use App\Models\EntradaBlog;
use Illuminate\Database\Seeder;

class EntradaBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntradaBlog::factory()->count(5)->create();
    }
}
