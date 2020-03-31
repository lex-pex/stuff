<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            [
                'user_id' => 2,
                'role_id' => 1,
                'created_at' => date('Y-m-d H:i:s', time())
            ],
            [
                'user_id' => 3,
                'role_id' => 2,
                'created_at' => date('Y-m-d H:i:s', time())
            ],
            [
                'user_id' => 4,
                'role_id' => 3,
                'created_at' => date('Y-m-d H:i:s', time())
            ],
        ]);
    }
}
