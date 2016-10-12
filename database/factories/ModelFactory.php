<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'color' => $faker->safeColorName,
    ];
});

$factory->define(App\Name::class, function (Faker\Generator $faker) {
    return [];
});

$factory->define(App\Revision::class, function (Faker\Generator $faker) {

    $names = App\Name::select('id')->pluck('id');
    $users = App\User::select('id')->pluck('id');

    return [
        'name_id'          => $names->random(),
        'user_id'          => $users->random(),
        'revision_title'   => ucfirst(implode(' ', $faker->words(3))),
        'name'             => $faker->firstNameMale . ' ' . $faker->lastName,
        'verse'            => $faker->paragraph,
        'meaning_function' => $faker->paragraph,
        'identical_titles' => $faker->paragraph,
        'significance'     => $faker->paragraph,
        'responsibility'   => $faker->paragraph,
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {

    $names = App\Name::select('id')->pluck('id');
    $users = App\User::select('id')->pluck('id');
    $enum  = App\Comment::getEnumValues('comment_on');
    $idx   = array_rand($enum);

    return [
        'name_id'    => $names->random(),
        'user_id'    => $users->random(),
        'comment'    => $faker->paragraph,
        'comment_on' => $enum[$idx],
    ];
});

