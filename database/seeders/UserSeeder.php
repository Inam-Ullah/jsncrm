<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        $users = [
            [
                'id' => 1,
                'role_id' => 1,
                'isp_id' => 1,
                'city_id' => 1,
                'name' => 'Onezeroart LLC',
                'username' => 'superadmin',
                'email' => 'support@onezeroart.com',
                'email_verified_at' => now(),
                'password' => $password,
                'photo' => '20180608_023729_477186.JPG',
                'nic' => '1234567890',
                'phone' => '8800000000000',
                'lang' => 'en',
                'address' => 'Dhaka',
                'status' => 1,
                'sms_status' => false,
                'credit_limit' => 0,
                'percentage' => 0,
                'nas_id' => 5,
                'last_login_at' => '2026-08-28 15:40:31',
                'created_at' => '2018-06-08 17:59:45',
            ],
            [
                'id' => 2,
                'role_id' => 2,
                'isp_id' => 1,
                'city_id' => 1,
                'name' => 'Jsons Netowks',
                'username' => 'admin',
                'email' => 'admin@site.com',
                'email_verified_at' => now(),
                'password' => $password,
                'photo' => '20230531_122728_379575.png',
                'nic' => '5345234523344',
                'phone' => '5675673454534',
                'lang' => 'en',
                'address' => 'Gulshan Iqbal',
                'status' => 1,
                'sms_status' => false,
                'credit_limit' => 0,
                'percentage' => 0,
                'nas_id' => 5,
                'last_login_at' => '2026-08-29 20:17:43',
                'created_at' => '2018-06-08 14:37:31',
            ],
        ];

        foreach ($users as $attributes) {
            User::updateOrCreate(['id' => $attributes['id']], $attributes);
        }

        $this->command?->info('Legacy Super Admin and Admin seeded. Password: 12345678');
    }
}
