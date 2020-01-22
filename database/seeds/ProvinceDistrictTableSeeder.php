<?php

use Illuminate\Database\Seeder;

class ProvinceDistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('province_district')->insert(config('province_district'));

    }
}
