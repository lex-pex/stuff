<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s', time())
            ],
            [
                'role' => 'moderator',
                'created_at' => date('Y-m-d H:i:s', time())
            ],
            [
                'role' => 'guest',
                'created_at' => date('Y-m-d H:i:s', time())
            ],
        ]);
    }
}
