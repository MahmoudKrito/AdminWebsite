<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $user = User::whereEmail('superAdmin@mail.com')->first();
        if(!$user){
            User::create([
                'name' => 'Super Admin',
                'email' => 'superAdmin@mail.com',
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
