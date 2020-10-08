<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create([
           'name' => 'teams.user.view.own'
        ]);

        Permission::create([
            'name' => 'teams.admin.view.all'
        ]);

        // Has access to the teams feature
        Permission::create([
            'name' => 'teams.view'
        ]);

        Permission::create([
            'name' => 'teams.admin.create',
        ]);
        Permission::create([
            'name' => 'teams.admin.delete',
        ]);
        Permission::create([
            'name' => 'teams.user.join',
        ]);
        Permission::create([
            'name' => 'teams.user.leave',
        ]);
        Permission::create([
            'name' => 'teams.admin.vacancies.assign',
        ]);
        Permission::create([
            'name' => 'teams.admin.vacancies.unassign',
        ]);
        Permission::create([
            'name' => 'teams.admin.applications.changeteam',
        ]);
        Permission::create([
            'name' => 'teams.members.appointment.schedule',
        ]);
        Permission::create([
            'name' => 'teams.members.appointment.deleteappointment',
        ]);
        Permission::create([
            'name' => 'teams.members.groupchat',
        ]);

        Permission::create([
            'name' => 'chat.use',
        ]);
    }
}
