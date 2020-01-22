<?php

use Illuminate\Database\Seeder;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('settings')->insert([
            'option_name' => 'FB_LINK',
            'option_value' => 'http://facebook.com',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'PHONE',
            'option_value' => '000-000-0000',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'SENDING_EMAIL',
            'option_value' => 'info@sendign-email.com',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'RECEIVING_EMAIL',
            'option_value' => 'info@receiving-email.com',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'TWITTER_LINK',
            'option_value' => 'https://twitter.com',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'SEO_TITLE',
            'option_value' => 'Laravel Quick Start',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'SEO_DESCRIPTION',
            'option_value' => 'Laravel Quick Start helps for quick start of Larvel project.',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'SEO_KEYWORDS',
            'option_value' => 'laravel, laravel 5.1',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('settings')->insert([
            'option_name' => 'COMPANY_NAME',
            'option_value' => 'Company Name',
            'status'       => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);



    }
}
