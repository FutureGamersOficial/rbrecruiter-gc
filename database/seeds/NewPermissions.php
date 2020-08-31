<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class NewPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::create([
           'name' => 'developer'
        ]);

        Permission::create(['name' => 'admin.settings.view']);
        Permission::create(['name' => 'admin.settings.edit']);

        $developer->givePermissionTo('admin.developertools.use');


    }
}
