<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class mainnavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mainnav')->insert([
            'vrnoa' => 1,
            'module_id' => 1,
            'sub_module_id' => 1,
            'vr_title' => 'Add New User',
            'vr_type' => 'vouchers',
            'is_visible' => 1,
            'sort_order' => 1,
            'vr_rights' => 'uservoucher',
            'vr_icon' => null,
            'vr_post_method' => null,
            'company_id' => 1,
            'uid' => 1,
            'is_tax' => null,
            'report_dynamically_parm' => null,
            'report_id' => null,
            'route_dynamic_id' => 1,
        ]);
    }
}
