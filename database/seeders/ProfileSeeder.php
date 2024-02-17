<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = Profile::create([ //ID = 1
            'name'    => "Kareem Tarek",
            'gender'  => "male",
            // 'avatar'  => "/assets/dashboard/images/profiles/avatars/kareemtarekdev.jpg",
            'avatar'  => "public/assets/dashboard/images/users/profiles/avatars/KareemDEV/kareemtarekdev.jpg",
            'user_id' => 6
        ]);

        $profile = Profile::create([ //ID = 2
            'name'    => "Eslam Hatab",
            'gender'  => "male",
            // 'avatar'  => "/assets/dashboard/images/profiles/avatars/mrhatab.jpg",
            'avatar'  => "public/assets/dashboard/images/users/profiles/avatars/Mr. Hatab/mrhatab.jpg",
            'user_id' => 7
        ]);

        $profile = Profile::create([ //ID = 3
            'name'    => "StockCoders™",
            'avatar'  => "public/assets/dashboard/images/users/profiles/avatars/StockCoders/stockcoders.png",
            'user_id' => 8
        ]);
    }
}
