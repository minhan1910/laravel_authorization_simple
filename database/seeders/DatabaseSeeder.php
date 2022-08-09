<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $groupId = DB::table('groups')->insertGetId([
            'name' => 'Administrator',
            'user_id' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($groupId > 0) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Min An',
                'email' => 'annogo123@gmail.com',
                'password' => Hash::make('123456'),
                'group_id' => $groupId,
                'user_id' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($userId > 0) {
                for ($i = 1; $i <= 5; ++$i) {
                    DB::table('posts')->insertGetId([
                        'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                        'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                        'user_id' => $userId,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}