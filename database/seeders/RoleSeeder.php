<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('roles')->upsert([
            ['id' => 1, 'name' => 'Super Admin', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Admin', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Franchise', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Dealer', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'Subdealer', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'Reseller', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name' => 'Customer', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'name' => 'Supervisor', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'name' => 'Sales Person', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'name' => 'Accounts', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 11, 'name' => 'Support', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 12, 'name' => 'Recovery', 'permission_id' => null, 'created_at' => $now, 'updated_at' => $now],
        ], ['id'], ['name', 'permission_id', 'updated_at']);
    }
}
