<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class banks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            DB::table('banks')->insert([
                ['uuid' => (string) Str::uuid(), 'name' => 'GolbalIME', 'balance' => '100000'],
                ['uuid' => (string) Str::uuid(), 'name' => 'NIC Asia', 'balance' => '250000'],

            ]);
        }
    }
}
