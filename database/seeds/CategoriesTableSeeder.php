<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'General Events'],
            ['name' => 'Troubleshooting'],
            ['name' => 'Matching Hold'],
            ['name' => 'Further Goals'],
            ['name' => 'Side Fixture'],
        ];
        DB::table('categories')->insert($categories);
    }
}
