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
            'username'              => "Mohamed Qadri",
            'email'                 => "doctor1@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01100000111",
            'user_type'             => "doctor",
            "user_role"             => "dentist",
            "account_status"        => "active", // The default value is already "active"
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);

        $user = User::create([ //ID = 2 (user_type = doctor)
            'username'              => "Heba Hatab",
            'email'                 => "doctor2@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01100000222",
            'user_type'             => "doctor",
            "user_role"             => "dentist",
            // "account_status"        => "active", // The default value is already "active"
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);

        $user = User::create([ //ID = 3 (user_type = doctor)
            'username'              => "Randa Mustafa",
            'email'                 => "doctor3@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01100000333",
            'user_type'             => "doctor",
            "user_role"             => "dental assistant",
            "account_status"        => "suspended",
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);

        $user = User::create([ //ID = 4 (user_type = employee)
            'username'              => "Ramy Diab",
            'email'                 => "employee1@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01200000111",
            // 'user_type'             => "employee", // The default value is already "employee"
            "user_role"             => "receptionist",
            "account_status"        => "active",
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);

        $user = User::create([ //ID = 5 (user_type = employee)
            'username'              => "Sandra Emad",
            'email'                 => "employee2@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01500000111",
            // 'user_type'             => "employee", // The default value is already "employee"
            "user_role"             => "floor cleaner",
            "account_status"        => "deactivated",
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);

        $user = User::create([ //ID = 6 (user_type = developer)
            'username'              => "KareemDEV",
            'email'                 => "kareemtarekpk@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01010110457",
            'user_type'             => "developer",
            "user_role"             => "IT",
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);

        $user = User::create([ //ID = 7 (user_type = developer)
            'username'              => "Mr. Hatab",
            'email'                 => "mr.hatab055@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01018162571",
            'user_type'             => "developer",
            "user_role"             => "IT",
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);

        $user = User::create([ //ID = 8 (user_type = developer)
            'username'              => "StockCoders",
            'email'                 => "stockcoders99@gmail.com",
            'password'              => '$2y$12$kl2xvidqwUgZLfnKzmMpK.lM0lnlHJS.ys.Dhokyuu4hRVplopGqS',
            'phone'                 => "01061770559",
            'user_type'             => "developer",
            "user_role"             => "IT",
            'registration_datetime' => Carbon::now(),
            'last_login_datetime'   => null,
        ]);
    }
}
