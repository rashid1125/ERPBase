<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            companySeeder::class,
            route_dynamicSeeder::class,
            rolegroupSeeder::class,
            userInsert::class,
            financialyearSeeder::class,
            mainnavmoduleSeeder::class,
            submainnavmoduleSeeder::class,
            etypenarrationsSeeder::class,
            mainnavSeeder::class,
        ]);
    }
}
