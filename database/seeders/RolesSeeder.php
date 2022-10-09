<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Admin', 'Editor', 'Moderator'
        ];
        foreach  ($list as $item) {
            DB::table('roles')->insert([
                  'title' => $item,
                  'description' => fake()->text(255),
              ]);
        }
    }
}
