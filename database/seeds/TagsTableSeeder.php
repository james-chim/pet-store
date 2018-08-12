<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name' => 'Dogs'
        ]);
        DB::table('tags')->insert([
            'name' => 'Cats'
        ]);
        DB::table('tags')->insert([
            'name' => 'Rabbits'
        ]);
    }
}
