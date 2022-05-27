<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class etypenarrationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('etypenarrations')->insert([
            'etype' => 'uservoucher',
            'voucherrights' => 'uservoucher',
            'narration' => null,
            'refurl' => null,
            'vr_title' => null,
            'vr_link' => null,
            'sort_by' => null,
            'etype_abbreviates' => null,
            'transaction_type' => null,
        ]);
    }
}
