<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Faker\Factory as Faker;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=0; $i<5; $i++)
        {
            DB::table('notices')->insert([
                'title'=> $faker->realText(10),
                'medium'=> $faker->realText(130),
                'date'=> Carbon::now('-05:00'),
                'file'=> Storage::path('public\\img\\test\\img_test_'.$i.'.png'),
            ]);
        }
    }
}
