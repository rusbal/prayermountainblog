<?php

use Illuminate\Database\Seeder;

class NamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Name::class, 10)->create()->each(function($name) {
            $faker = Faker\Factory::create('en_US');
            $name->revisions()->save(
                new App\Revision([
                    'revision_title'   => 'First Draft',
                    'name'             => $faker->firstNameMale . ' ' . $faker->lastName,
                    'verse'            => '',
                    'meaning_function' => '',
                    'identical_titles' => '',
                    'significance'     => '',
                    'responsibility'   => '',
                    'user_id'          => App\User::all()->random()->id
                ])
            );
        });
    }
}
