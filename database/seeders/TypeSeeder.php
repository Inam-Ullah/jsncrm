<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('types')->upsert([
            ['type' => 'status', 'data' => 0, 'description' => 'Disable', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'status', 'data' => 1, 'description' => 'Active', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'userstatus', 'data' => 0, 'description' => 'Disable', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'userstatus', 'data' => 1, 'description' => 'Register', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'userstatus', 'data' => 2, 'description' => 'Active', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'invtype', 'data' => 1, 'description' => 'Own', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'invtype', 'data' => 2, 'description' => 'Franchise', 'created_at' => $now, 'updated_at' => $now],
        ], ['type', 'data'], ['description', 'updated_at']);
    }
}
