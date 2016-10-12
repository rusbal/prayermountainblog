<?php

use Illuminate\Database\Seeder;

use App\Name;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::truncate();
        App\Name::truncate();
        App\Revision::truncate();
        App\Comment::truncate();

        $this->call(UsersTableSeeder::class);
        // $this->call(NamesTableSeeder::class);
        //
        // /**
        //  * Set name.number to be equal to name.id
        //  */
        // foreach (Name::all() as $name) {
        //     $name->order = $name->id;
        //     $name->status = 'In progress';
        //     $name->save();
        // }
        //
        // $this->call(RevisionsTableSeeder::class);
        // $this->call(CommentsTableSeeder::class);
    }
}
