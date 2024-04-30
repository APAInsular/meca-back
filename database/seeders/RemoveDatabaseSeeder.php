<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemoveDatabaseSeeder extends Seeder
{
    /**
     * Reverse the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Eliminar registros de las tablas
        // DB::table('monuments')->truncate();
        // DB::table('styles')->truncate();
        // DB::table('addresses')->truncate();
        // DB::table('achievements')->truncate();
        // DB::table('sub_achievements')->truncate();
        // DB::table('events')->truncate();
        DB::table('routes')->truncate();
        // DB::table('sponsors')->truncate();
        // DB::table('images')->truncate();
        // DB::table('ratings')->truncate();
        DB::table('qrs')->truncate();
        // DB::table('blog_entries')->truncate();
        // DB::table('saves')->truncate();
        // DB::table('tags')->truncate();
        // DB::table('likes')->truncate();
        // DB::table('authors')->truncate();
        // DB::table('categories')->truncate();
        // DB::table('permissions')->truncate();

        // Eliminar registros de tablas pivot si es necesario
        // Por ejemplo:
        // DB::table('author_monument')->truncate();
        // DB::table('monument_user')->truncate();
        // DB::table('address_user')->truncate();
        // DB::table('achievement_user')->truncate();
        // DB::table('sub_achievement_user')->truncate();
        // DB::table('event_route')->truncate();
        // DB::table('event_user')->truncate();
        // DB::table('monument_route')->truncate();
        // DB::table('route_user')->truncate();
        // DB::table('stop_user')->truncate();
        // DB::table('blog_entry_category')->truncate();
        // DB::table('blog_entry_tag')->truncate();
        // DB::table('blog_entry_user')->truncate();
        // DB::table('permission_role')->truncate();
    }
}

