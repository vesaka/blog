<?php

use Illuminate\Database\Seeder;
use App\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Role();
        $role_user->rank = 'Admin';
        $role_user->description = 'This role has complete access to all application resources!';
        $role_user->save();
        
        $role_user = new Role();
        $role_user->rank = 'Moderator';
        $role_user->description = 'A user with partial acces to application resources!';
        $role_user->save();
        
        $role_user = new Role();
        $role_user->rank = 'User';
        $role_user->description = 'Use with limited acces!';
        $role_user->save();
        
    }
}
