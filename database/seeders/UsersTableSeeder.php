<?php

namespace Database\Seeders;

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
        \DB::table("users")->truncate();

        \DB::table("users")->insert([
            'status' => 1,
            "name" => "Nenad Popadic",
            "email" => "popadic01@gmail.com",
            'phone' => '+38169630093',
            "password" => \Hash::make("bloguser"),
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ]);

        \DB::table("users")->insert([
            'status' => 1,
            'name' => 'Petar Petrovic',
            'email' => 'petar.petrovic@gmail.com',
            'phone' => '+38164555888',
            'password' => \Hash::make('bloguser'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table("users")->insert([
            'status' => 1,
            'name' => 'Nikola Nikolic',
            'email' => 'nikola.nikolic@gmail.com',
            'phone' => '+381615558848',
            'password' => \Hash::make('bloguser'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table("users")->insert([
            'status' => 1,
            'name' => 'Jelena Markovic',
            'email' => 'jelena.markovic@gmail.com',
            'phone' => '+381645234428',
            'password' => \Hash::make('bloguser'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table("users")->insert([
            'status' => 1,
            'name' => 'Masa Vasovic',
            'email' => 'masa.vasovic@gmail.com',
            'phone' => '+381635754577',
            'password' => \Hash::make('bloguser'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
