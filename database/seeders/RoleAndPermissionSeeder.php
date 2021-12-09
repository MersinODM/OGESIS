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

        // create permissions
//        Permission::create(['name' => 'teacher.create.admin', 'slug' => 'Öğretmen Oluşturma(Üst Yönetici)']);
//        Permission::create(['name' => 'teacher.create.manager', 'slug' => 'Öğretmen Oluşturma(Müdür)']);
//        Permission::create(['name' => 'teacher.update.admin', 'slug' => 'Öğretmen Güncelleme(Üst Yönetici)']);
//        Permission::create(['name' => 'teacher.update.manager', 'slug' => 'Öğretmen Güncelleme(Müdür)']);
//        Permission::create(['name' => 'teacher.delete', 'slug' => 'Öğretmen Silme']);
//
//        Permission::create(['name' => 'team.create.admin', 'slug' => 'Takım Oluşturma(Üst Yönetici)']);
//        Permission::create(['name' => 'team.create.manager', 'slug' => 'Takım Oluşturma(Müdür)']);
//        Permission::create(['name' => 'team.update.admin', 'slug' => 'Takım Güncelleme(Üst Yönetici)']);
//        Permission::create(['name' => 'team.update.manager', 'slug' => 'Takım Güncelleme(Müdür)']);
//        Permission::create(['name' => 'team.delete', 'slug' => 'Takım Silme']);
//
//        Permission::create(['name' => 'team.add-member.admin', 'slug' => 'Takıma Üye Ekleme(Üst Yönetici)']);
//        Permission::create(['name' => 'team.add-member.manager', 'slug' => 'Takıma Üye Ekleme(Müdür)']);
//        Permission::create(['name' => 'team.remove-member.admin', 'slug' => 'Takımdan Üye Çıkarma(Üst Yönetici)']);
//        Permission::create(['name' => 'team.remove-member.manager', 'slug' => 'Takımdan Üye Çıkarma(Müdür)']);


//        Permission::create(['name' => 'delete articles']);
//        Permission::create(['name' => 'publish articles']);
//        Permission::create(['name' => 'unpublish articles']);

        Role::create(['name' => 'admin', 'slug' => 'Sistem Yöneticisi'])
            ->givePermissionTo(Permission::all());

        // or may be done by chaining
        Role::create(['name' => 'Province-Manager', 'slug' => 'İl Yöneticisi']);
        Role::create(['name' => 'District-Manager', 'slug' => 'İlçe Yöneticisi']);
        Role::create(['name' => 'School-Manager', 'slug' => 'Okul Yöneticisi']);
        Role::create(['name' => 'Teacher', 'slug' => 'Öğretmen']);
    }
}
