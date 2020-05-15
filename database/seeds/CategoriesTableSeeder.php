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
            /**
             * Main Category #1 by Default. Doesn't have any own items.
             * Represents all categories, while has all other properties.
             */
            ['id' => 1, 'name' => 'All Categories'],
            /**
             * Another 5 mock categories
             */
            ['id' => 2, 'name' => 'General Events'],
            ['id' => 3, 'name' => 'Troubleshooting'],
            ['id' => 4, 'name' => 'Matching Hold'],
            ['id' => 5, 'name' => 'Further Goals'],
            ['id' => 6, 'name' => 'Side Fixture'],
        ];
        DB::table('categories')->insert($categories);
    }
}
