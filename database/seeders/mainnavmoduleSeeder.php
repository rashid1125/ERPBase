<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class mainnavmoduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mainnavmodule')->insert(array(
            'module_name' => 'Setup',
            'module_icon' => 'fas fa-tachometer-alt',
            'module_rights' => 'SetupManagementModule',
            'is_visible' => 1,
            'sort_order' => 1,
            'display' => 1,
            'company_id' => 1,
            'uid' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ));
    }
}
