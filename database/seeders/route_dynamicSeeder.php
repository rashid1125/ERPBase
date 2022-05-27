<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class route_dynamicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('route_dynamics')->insert(array(
            'name' => 'dashboard',
            'slug' => 'user/dashboard',
            'controller_name' => 'UserController',
            'function_name' => 'dashboard',
            'function_method' => 'get',
            'content' => 'dashboard',
        ));
    }
}
