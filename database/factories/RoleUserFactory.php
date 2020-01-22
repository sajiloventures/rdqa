<?php

use Faker\Generator as Faker;

$factory->define(App\Models\RoleUser::class, function (Faker $faker) {
    return [
       // 'church_id' =>function () {
       //      return factory(App\Models\Church::class)->create()->id;
       //  },
       'role_id' => App\Models\Role::all()->random()->id,
    ];
});
