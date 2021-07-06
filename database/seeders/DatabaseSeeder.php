<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()  //used to initialization of database
    {
        DB::table('users')->insert([
            ['name' => 'ali', 'email' => 'ali@gmail.com','password' => Hash::make('1234'),],
            ['name' => 'akbar', 'email' => 'akbar@gmail.com','password' => Hash::make('1234')],
            ['name' => 'ahmad', 'email' => 'ahmad@gmail.com','password' => Hash::make('1234')],
            ['name' => 'tural', 'email' => 'tural@gmail.com','password' => Hash::make('5678')],
            ['name' => 'togrol', 'email' => 'togrol@gmail.com','password' => Hash::make('5678')],
        ]);
        $akbarId = DB::table('users')->where('email','akbar@gmail.com')->first()->id;
        $togrolId = DB::table('users')->where('email','togrol@gmail.com')->first()->id;
        DB::table('groups')->insert([
            ['group_name' => 'monkeys', 'admin_id' => $akbarId],
            ['group_name' => 'donkeys', 'admin_id' => $togrolId],

        ]);
    }
}
