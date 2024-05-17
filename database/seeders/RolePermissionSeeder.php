<?php

// database/seeders/RolePermissionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Public User' => [
                'access_public_works_info',
                'access_public_routes',
                'read_public_blog',
            ],
            'Private User' => [
                'access_complete_works_info',
                'view_private_routes_events',
                'read_comment_public_blog',
            ],
            'Moderator' => [
                'edit_delete_blog_comments',
                'moderate_routes_events',
                'verify_completed_achievements',
            ],
            'Event Admin' => [
                'create_edit_delete_events',
                'assign_roles_for_events',
                'manage_participation_in_events',
            ],
            'Admin' => [
                '*', // All permissions
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            if ($permissions[0] == '*') {
                $role->syncPermissions(Permission::all());
            } else {
                foreach ($permissions as $permissionName) {
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);
                    $role->givePermissionTo($permission);
                }
            }
        }
    }
}
