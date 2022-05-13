<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_states')->insert([
            'name' => 'Pending',
        ]);

        DB::table('user_states')->insert([
            'name' => 'Aprroved',
        ]);

        DB::table('user_states')->insert([
            'name' => 'Rejected',
        ]);
    }
}
