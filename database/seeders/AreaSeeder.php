<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('areas')->upsert([
            [
                'id' => 1,
                'parent_id' => null,
                'type' => 'city',
                'name' => 'Rahim Yar Khan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'type' => 'area',
                'name' => 'Gulshan Iqbal',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['id'], ['parent_id', 'type', 'name', 'updated_at']);
    }
}
