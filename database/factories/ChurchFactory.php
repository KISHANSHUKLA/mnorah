<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Church;
use Faker\Generator as Faker;
$factory->define(Church::class, function (Faker $faker) {
    return [

        'user_id' => $faker->numberBetween(1,10),
        'denomination' => 'Lorem Lorem',
        'venue' => 'Lorem Lorem',       
        'days' => $faker->dateTime(),
        'language' => 'Lorem Lorem',
        'Social' => 'https://www.google.com',
        'vision' => 'Lorem Lorem',
        'leadership' => 'Lorem Lorem',
        'ministries' => 'Lorem Lorem',
        'event' => 'Lorem Lorem',
        'eventimage' => json_encode(
            [
                '0'=>'https://i1.wp.com/www.parkingspace23.com/wp-content/uploads/2018/06/church1.jpg'
                ]),
    ];
    
});
