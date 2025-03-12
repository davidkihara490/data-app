<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createCRUDPermissions('users');
        $this->createCRUDPermissions('templates');
        $this->createCRUDPermissions('validation_rules');
        $this->createCRUDPermissions('work_flow');
        $this->createCRUDPermissions('roles');
       
        // =========================================================
        // Finally give the super admin all the above permissions
        // =========================================================

        $superAdmin = $this->createRole('super-admin');
        Permission::all()->each(fn(Permission $permission) => $permission->assignRole($superAdmin));
        // \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        $this->createRole('Approver');
        $this->createRole('Operator');
    }

    public function createRole(string $name): Role
    {
        return Role::query()->updateOrCreate(['name' => $name]);
    }

    public function createPermission(string $name): Permission
    {
        return Permission::query()->updateOrCreate(['name' => $name]);
    }

    public function createCRUDPermissions(string $name): void
    {
        $this->createPermission("$name.create");
        $this->createPermission("$name.view");
        $this->createPermission("$name.update");
        $this->createPermission("$name.delete");
        $this->createPermission("generate_data");
        $this->createPermission("validate_data");
        $this->createPermission("approve_data");
        $this->createPermission("integrate_data");
        $this->createPermission("archive_data");
        $this->createPermission("view_dashboard");
        $this->createPermission("view_system_logs");
    }
}
