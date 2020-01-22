<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
            'name' => 'super-admin',
            'display_name' => 'Super admin',
            'description' => 'This role has full permission.',
            'enabled' => true,
            'position' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'admins',
            'display_name' => 'Administrators',
            'description' => 'Site administrators',
            'enabled' => true,
            'position' => 2,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'users',
            'display_name' => 'Users',
            'description' => 'Authenticated users',
            'enabled' => true,
            'position' => 3,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);



        DB::table('roles')->insert([
            'name' => 'rdqa-admin',
            'display_name' => 'RDQA admin',
            'description' => 'This role manages all other users under him.',
            'enabled' => true,
            'position' => 4,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'province-user',
            'display_name' => 'Province User',
            'description' => 'This role manages all other users under him.',
            'enabled' => true,
            'position' => 5,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'district-user',
            'display_name' => 'District User',
            'description' => 'This role manages all other users under him.',
            'enabled' => true,
            'position' => 6,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'palika-user',
            'display_name' => 'Palika User',
            'description' => 'Palika User.',
            'enabled' => true,
            'position' => 7,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);


        DB::table('roles')->insert([
            'name' => 'facility-user',
            'display_name' => 'Facility User',
            'description' => 'Facility User.',
            'enabled' => true,
            'position' => 8,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

     
    }
}
