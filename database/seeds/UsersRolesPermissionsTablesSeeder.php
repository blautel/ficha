<?php
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class UsersRolesPermissionsTablesSeeder extends Seeder
{
    public function run()
    {
        # permissions
        Permission::create(['name' => 'gest-accesos']);
        Permission::create(['name' => 'gest-proyectos']);
        # roles
        Role::create(['name' => 'administrador'])
            ->givePermissionTo('gest-accesos')
            ->givePermissionTo('gest-proyectos');
        # users
        User::create(['name' => 'XB', 'email' => 'admin@admin.com', 'password' => bcrypt('admin')])
            ->assignRole('administrador');
        User::create(['name' => 'MP', 'email' => 'user1@example.com', 'password' => bcrypt('user1')]);
        User::create(['name' => 'LF', 'email' => 'user2@example.com', 'password' => bcrypt('user2')]);
    }
}
