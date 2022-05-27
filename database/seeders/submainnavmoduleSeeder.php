<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class submainnavmoduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submainnavmodule')->insert(array(
            'module_id' => 1,
            'sub_module_name' => 'Defination',
            'sub_module_icon' => 'fas fa-plus',
            'is_visible' => 1,
            'company_id' => 1,
            'uid' => 1,
            'sort_order' => 1,
        ));
    }
}
