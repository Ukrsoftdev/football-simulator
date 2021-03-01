<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            ["title"=>"A","division"=>"A"],
            ["title"=>"B","division"=>"A"],
            ["title"=>"C","division"=>"A"],
            ["title"=>"D","division"=>"A"],
            ["title"=>"E","division"=>"A"],
            ["title"=>"F","division"=>"A"],
            ["title"=>"G","division"=>"A"],
            ["title"=>"H","division"=>"A"],
            ["title"=>"I","division"=>"B"],
            ["title"=>"J","division"=>"B"],
            ["title"=>"K","division"=>"B"],
            ["title"=>"L","division"=>"B"],
            ["title"=>"M","division"=>"B"],
            ["title"=>"N","division"=>"B"],
            ["title"=>"O","division"=>"B"],
            ["title"=>"P","division"=>"B"]
        ]);
    }
}
