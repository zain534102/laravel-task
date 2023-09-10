<?php
namespace Database\Factories;

use App\Modules\UserSubmissions\UserSubmission;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(UserSubmission::class, function (Faker $faker) {
    return [
        'name' => fake()->name(),
        'message' => fake()->sentence()
    ];
});
