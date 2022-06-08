<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        $user = User::factory()->make();
        $user->email = 'podstock@example.net';
        $user->password = Hash::make('1234');
        $user->save();
        /* $user->roles()->attach(1); */
        /* $user->roles()->attach(2);        // \App\Models\User::factory(10)->create(); */
    }
}
