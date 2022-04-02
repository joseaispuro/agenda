<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
             'name' => 'Administrador',
             'email'    => 'admin@gmail.com',
             'user' => 'admin',
             'password' => bcrypt('admin'),
             "created_at" => date("Y-m-d H:i:s"),
             "updated_at" => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
