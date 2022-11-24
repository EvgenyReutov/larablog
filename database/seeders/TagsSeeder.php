<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Linux', 'Bitrix', 'Laravel', 'Mysql', 'Php', 'Javascript',
            'VueJs',
        ];
        foreach  ($tags as $tag) {
            $time = fake()->dateTime;
            $code = strtolower($tag);
            DB::table('tags')->insert([
               'title' => $tag,
               'code' => $code,
               'created_at' => $time,
               'updated_at' => $time,
           ]);
        }
    }
}
