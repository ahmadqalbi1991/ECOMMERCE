<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
                'is_active' => 1,
                'city_id' => null
            ]
        ]);
    }
}
