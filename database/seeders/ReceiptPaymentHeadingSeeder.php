<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ReceiptPaymentHeadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('receipt_payment_headings')->insert([
            ['uuid' => (string) Str::uuid(), 'heading' => 'Tuition Fees', 'type' => 'receipt'],
            ['uuid' => (string) Str::uuid(), 'heading' => 'Library Fines', 'type' => 'receipt'],
            ['uuid' => (string) Str::uuid(), 'heading' => 'Salaries', 'type' => 'payment'],
            ['uuid' => (string) Str::uuid(), 'heading' => 'Maintenance', 'type' => 'payment'],
        ]);
    }
}
