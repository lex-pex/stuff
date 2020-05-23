<?php


use Illuminate\Database\Seeder;


class CategoriesAliasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = \App\Models\Category::all();
        for($i = 0; $i < count($c); $i ++) {
            if(!$c[$i]->alias) {
                $c[$i]->alias = \App\Helpers\AliasProcessor::getAlias($c[$i]->name, $c[$i]);
                $c[$i]->save();
            }
        }
    }
}
