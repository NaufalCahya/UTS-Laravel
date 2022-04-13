<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //masukkan data name, email, password ke tabel user
        User::create([
        	'name' -> {'Administrator'},
        	'email' -> {'admin@gmail.com'},
        	'password' -> Hash::make('admin')
        ]);
    }
}