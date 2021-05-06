<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
      'id' => ++Employee::$id,
      'first_name' => $faker->firstName(),
      'last_name' => $faker->lastName(),
      'email' => $faker->unique()->safeEmail(),
      'address' => $faker->address(),
      'job_role' => $faker->jobTitle()
    ];
});
