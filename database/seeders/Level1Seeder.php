<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Level1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('level1')->insert(array(
            'name' => 'Asstes',
            'company_id' => 1,
            'uid' => 1
        ));
    }
}
