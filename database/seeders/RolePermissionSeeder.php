<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            'User',

            'ActionEvent',

            'Country',
            'City',
            'Area',
            'Zone',
            'Currency',

            'Category',
            'Gender',
            'Layout',

            'Role',
            'Permission',
            // ... your own models/permission you want to crate
        ]);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['group' => $item, 'name' => 'index ' . $item, 'permission_name' => 'show all', 'permission_name_ar' => 'عرض الكل']);
            Permission::create(['group' => $item, 'name' => 'show ' . $item, 'permission_name' => 'show', 'permission_name_ar' => 'عرض']);
            Permission::create(['group' => $item, 'name' => 'store ' . $item, 'permission_name' => 'add new', 'permission_name_ar' => 'اضافه']);
            Permission::create(['group' => $item, 'name' => 'update ' . $item, 'permission_name' => 'update', 'permission_name_ar' => 'تعديل']);
            Permission::create(['group' => $item, 'name' => 'destroy ' . $item, 'permission_name' => 'delete', 'permission_name_ar' => 'حذف']);
            Permission::create(['group' => $item, 'name' => 'restore ' . $item, 'permission_name' => 'restore', 'permission_name_ar' => 'استعاده']);
            Permission::create(['group' => $item, 'name' => 'forceDelete ' . $item, 'permission_name' => 'force delete', 'permission_name_ar' => 'حذف نهائى']);
        });

        // Create a Super-Admin Role and assign all permissions to it
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Give User Super-Admin Role
        $user = User::whereEmail('superAdmin@mail.com')->first(); // enter your email here
        $user->assignRole('super-admin');
    }
}
