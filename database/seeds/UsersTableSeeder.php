<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('87654321'),
                'created_at' => date('Y-m-d H:i:s', time())
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@mail.com',
                'password' => bcrypt('87654321'),
                'created_at' => date('Y-m-d H:i:s', time())
            ],
            [
                'name' => 'User',
                'email' => 'user@mail.com',
                'password' => bcrypt('87654321'),
                'created_at' => date('Y-m-d H:i:s', time())
            ]
        ]);
    }
}
