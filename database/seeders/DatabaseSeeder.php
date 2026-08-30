<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AreaSeeder::class,
            TypeSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
