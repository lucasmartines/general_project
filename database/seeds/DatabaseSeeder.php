<?php

use Illuminate\Database\Seeder;

use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'lucas',
            'email' => 'admin@email.com',
            'password' => bcrypt('adminadmin'),

        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
