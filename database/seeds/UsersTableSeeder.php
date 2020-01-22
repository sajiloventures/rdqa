<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username'   => 'root',
            'first_name' => 'Root',
            'last_name'  => 'User',
            'email'      => 'root@admin.com',
            'enabled'    => true,
            'password'   => bcrypt('password'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
        ]);

        /*
         * roles to he user
         * */
        // User root is a member of admins.
        DB::table('role_user')->insert([
            'user_id' => 1, // root
            'role_id' => 1, // admins
        ]);

        // User root is a member of users.
        DB::table('role_user')->insert([
            'user_id' => 1, // root
            'role_id' => 2, // users
        ]);

        // User root is a member of super-admin.
        DB::table('role_user')->insert([
            'user_id' => 1, // root
            'role_id' => 3, // super-admin
        ]);
        /*create 25 fake users*/
//        factory(App\User::class, 25)->create()->each(function ($u) {
//            $u->roleuser()->save(factory(App\Models\RoleUser::class)->make());
//        });
    }
}
