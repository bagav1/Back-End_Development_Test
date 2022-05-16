<?php

namespace Database\Seeders;

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
        for($i=0; $i<3; $i++)
        {
            DB::table('notices')->insert([
                'title'=> $faker->realText(10),
                'medium'=> $faker->realText(130),
                'date'=> Carbon::now('-05:00'),
                'file'=> 'http://127.0.0.1:8000/storage/img/test/iimg_test_'.$i.'.png',
            ]);
        }
    }
}
