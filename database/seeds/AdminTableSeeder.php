<?php

use App\Admin\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Admin::create([
            'name' => "Name Surname",
            'email' => "admin@gmail.com",
            'password' => Hash::make('123456'),
            'role' => 1,
        ]);
    }
}
