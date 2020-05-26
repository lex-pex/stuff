<?php

use Illuminate\Database\Seeder;

class ItemAliasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = \App\Models\Item::all();
        for($i = 0; $i < count($c); $i ++) {
            if(!$c[$i]->alias) {
                $c[$i]->alias = \App\Helpers\AliasProcessor::getAlias($c[$i]->title, $c[$i]);
                $c[$i]->save();
            }
        }
    }
}
