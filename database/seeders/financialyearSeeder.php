<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class financialyearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('financialyear')->insert(array(
            'financialyear_name' => 'Session 22',
            'financialyear_remarks' => 'Session 22',
            'financialyear_start_date' => now(),
            'financialyear_end_date' => date("Y-m-d", strtotime(date("Y-m-d", strtotime(now())) . " + 1 year")),
            'company_id' => 1,
            'uid' => 1
        ));
    }
}
