<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'key' => 'timezone',
                'value' => 'UTC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'locale',
                'value' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'currency',
                'value' => 'USD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
