<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new UsersSeeder())->run();
        $this->call(RolesSeeder::class);
        //\App\Models\User::factory(10)->create();
        \App\Models\CommentLike::factory(5)->create();
        \App\Models\Subscriber::factory(5)->create();

        //(new UsersSeeder())->run();
        //$this->call(PostSeeder::class);

        $this->call(TagsSeeder::class);
        $this->call(PostTagSeeder::class);
        $this->call(RoleUserSeeder::class);


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
