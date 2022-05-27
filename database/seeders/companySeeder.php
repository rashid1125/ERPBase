<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class companySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->insert([
            'company_name' => 'Digitalsofts',
            'contact_person' => 'Usman Sajjid',
            'contact' => '03087994852',
            'heading' => 'Digitalsofts',
            'foot_note' => 'Digitalsofts',
            'address' => 'Rex City Faisalabad,Punjab,Pakistan',
            'allowed_users' => 1,
            'status' => 1,
            'expiry_date' =>  date("Y-m-d", strtotime(date("Y-m-d", strtotime(now())) . " + 1 year")),
            'date' =>  now(),
        ]);
    }
}
