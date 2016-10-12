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
        $faker = Faker\Factory::create('en_US');

        App\User::create([
            'name'     => 'Raymond Usbal',
            'initials' => '',
            'email'    => 'raymond@philippinedev.com',
            'password' => bcrypt('default'),
            'color'    => $faker->hexcolor,
        ]);

        App\User::create([
            'name'     => 'Arthur Macarubbo',
            'initials' => '',
            'email'    => 'arthur.macarubbo@yahoo.com',
            'password' => bcrypt('default'),
            'color'    => $faker->hexcolor,
        ]);
    }
}
