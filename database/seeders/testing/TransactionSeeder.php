<?php

namespace Database\Seeders\Testing;

use App\Models\Revenue\Revenue;
use App\Models\Expense\Expense;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder 
{
    public function run()
    {
        $revenues = [
            [
                'category_id' => 1,
                'description' => 'Salário - Empresa A',
                'value' => 2250.50,
                'date_transaction' => '2024-01-05'
            ],
            [
                'category_id' => 2,
                'description' => 'Site - Venda de produtos',
                'value' => 1500.00,
                'date_transaction' => '2024-01-06'
            ],
            [
                'category_id' => 3,
                'description' => 'Empréstimo para João',
                'value' => 1000.00,
                'date_transaction' => '2023-12-10'
            ],
        ];

        $expenses = [
            [
                'category_id' => 1,
                'description' => 'Coca-cola',
                'value' => 10.00,
                'date_transaction' => '2024-01-01'
            ],
            [
                'category_id' => 2,
                'description' => 'Uber',
                'value' => 50.00,
                'date_transaction' => '2024-01-05'
            ],
            [
                'category_id' => 3,
                'description' => 'Conta de luz',
                'value' => 100.00,
                'date_transaction' => '2023-12-10'
            ],
        ];

        foreach ($revenues as $transaction) {
            Revenue::create($transaction);
        }

        foreach ($expenses as $transaction) {
            Expense::create($transaction);
        }
    }
}