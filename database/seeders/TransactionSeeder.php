<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::create([
            'order_number' => 'ORD-001',
            'customer_id' => 2,
            'book_id' => 1,
            'quantity' => 1,
            'total_amount' => 250000.00,
        ]);

        Transaction::create([
            'order_number' => 'ORD-002',
            'customer_id' => 2,
            'book_id' => 2,
            'quantity' => 1,
            'total_amount' => 500000.00,
        ]);
    }
}