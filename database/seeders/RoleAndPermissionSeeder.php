<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        // create permissions
        $permissionList = File::get(base_path('/storage/required/PermissionList.json'));
        $defaultPermissions = json_decode($permissionList);
        $permissions = [
            'Impersonate-create',
            'Impersonate-delete',
            ...$defaultPermissions,
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        //Role::create(['name' => 'Super-Admin']);
        $role = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $adminPermissions = [
            'Impersonate-create',
            'Impersonate-delete',
            ...$defaultPermissions,
        ];
        foreach ($adminPermissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $developerPermissions = [
            'Impersonate-create',
            'Impersonate-delete',
            ...$defaultPermissions,
        ];
        $developerRole = Role::create(['name' => 'developer', 'guard_name' => 'admin']);
        foreach ($developerPermissions as $permission) {
            $developerRole->givePermissionTo($permission);
        }

        Role::create(['name' => 'client', 'guard_name' => 'client']);
        //        foreach ($clientPermissions as $permission) {
        //            $clientRole->givePermissionTo($permission);
        //        }
    }
}
