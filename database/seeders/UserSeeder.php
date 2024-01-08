<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([ //ID = 1 (user_type = doctor)
            'username'           => "Mohamed Hatab",
            'email'              => "doctor1@gmail.com",
            'password'           => bcrypt('123456789'),
            'phone'              => "01100000111",
            'user_type'          => "doctor",
            "user_role"          => "dentist",
            'registration_date'  => now(),
            'last_login_date'    => now(),
        ]);

        $user = User::create([ //ID = 1 (user_type = doctor)
            'username'           => "Heba Hatab",
            'email'              => "doctor2@gmail.com",
            'password'           => bcrypt('123456789'),
            'phone'              => "01100000222",
            'user_type'          => "doctor",
            "user_role"          => "dentist",
            'registration_date'  => now(),
            'last_login_date'    => now(),
        ]);

        $user = User::create([ //ID = 3 (user_type = employee)
            'username'           => "Sandra Emad",
            'email'              => "employee@gmail.com",
            'password'           => bcrypt('123456789'),
            'phone'              => "01200000111",
            // 'user_type'          => "employee", // The default value is already "employee"
            "user_role"          => "receptionist",
            'registration_date'  => now(),
            'last_login_date'    => now(),
        ]);

        $user = User::create([ //ID = 4 (user_type = test)
            'username'           => "Ramy Diab",
            'email'              => "test@gmail.com",
            'password'           => bcrypt('123456789'),
            'phone'              => "01500000111",
            'user_type'          => "test",
            'registration_date'  => now(),
            'last_login_date'    => now(),
        ]);
    }
}
