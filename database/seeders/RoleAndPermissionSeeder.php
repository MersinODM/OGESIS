<?php

namespace Database\Seeders;

use App\Helpers\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = Permissions::getPermissions();
        foreach ($permissions as $permission => $slug) {
            Permission::create(['name' => $permission, 'slug' => $slug]);
        }

        Role::create(['name' => 'admin', 'slug' => 'Sistem Yöneticisi'])
            ->givePermissionTo(Permission::all());

        // or may be done by chaining
        Role::create(['name' => 'Province-Manager', 'slug' => 'İl Yöneticisi']);
        Role::create(['name' => 'District-Manager', 'slug' => 'İlçe Yöneticisi']);
        Role::create(['name' => 'School-Manager', 'slug' => 'Okul Yöneticisi']);
        Role::create(['name' => 'Teacher', 'slug' => 'Öğretmen']);
    }
}
