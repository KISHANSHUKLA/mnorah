<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Invitecode;
use Faker\Generator as Faker;

$factory->define(Invitecode::class, function (Faker $faker) {
    return [
    'invitecode' => $faker->title(),        
    ];
});
