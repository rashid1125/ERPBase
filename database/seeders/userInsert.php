<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userInsert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert(array(
            'date' => now(),
            'uname' => 'DS Admin',
            'pass' => Hash::make('Admin123456'),
            'fullname' => 'Digitalsofts',
            'email' => 'asimdigitals@gmail.com',
            'mobile' => '03087551520',
            'rgid' => '1',
            'company_id' => '1',
            'uuid' => '1',
            'failedattempts' => 0,
            'user_can_login_fn' => 1,
            'level3_id' => 1,
            'send_mail' => 1,
            'is_secure' => 1,
            'report_to_user' => 1,
            'photo' => null,
            'remember_token' => Str::random(60)
        ));
    }
}
