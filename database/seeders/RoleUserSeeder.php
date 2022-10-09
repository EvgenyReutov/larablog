<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all()->sortBy('id');
        $roles = \App\Models\Role::all()->sortBy('id');

        //$adminUser = $users->first();
        $adminRole = $roles->first();
        $otherRoles = $roles->where('id', '!=', $adminRole->id);

        $j = 0;
        foreach ($users as $user) {
            $j++;
            if ($j === 1) {
                DB::table('role_user')->insert([
                  'role_id' => $adminRole->id,
                  'user_id'  => $user->id,
              ]);
            } else {
                DB::table('role_user')->insert([
                   'role_id' => $otherRoles->random()->toArray()['id'],
                   'user_id'  => $user->id,
               ]);
            }

        }
    }
}
