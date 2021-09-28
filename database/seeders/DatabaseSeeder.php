<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            CountrySeeder::class
        ]);
        // create admin logins
        DB::table('carers')->insert([
            'name' => 'Talent',
            'surname' => 'Mbedzi',
            'email' => 'talentmbedzi@gmail.com',
            'remember_token' => Str::random(10),
            'password' => bcrypt('Tester@123'),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);
        DB::table('carers')->insert([
            'name' => 'Leo',
            'surname' => 'Rams',
            'email' => 'leoramsy@gmail.com',
            'remember_token' => Str::random(10),
            'password' => bcrypt('Tester@123'),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

    }
}
