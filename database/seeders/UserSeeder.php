<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email'=>'user1@tester.com',
            'password'=>'1234567890',
            'state_id'=>'2'
        ]);

        DB::table('users')->insert([
            'name' => 'Jimmy Dao',
            'email'=>'user2@tester.com',
            'password'=>'1234567890',
            'state_id'=>'1'
        ]);
    }
}
