<?php

namespace Database\Seeders\Testing;

use App\Models\Expense\ExpenseCategory;
use App\Models\Revenue\RevenueCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $revenueCategories = [
            [
                'name' => 'Salário', 
                'description' => 'Pagamento de trabalho fixo', 'color' => 'bg-green', 
                'icon' => 'bi bi-cash-coin'
            ],
            [
                'name' => 'Freelance', 
                'description' => 'Pagamento de trabalho avulso', 
                'color' => 'bg-blue', 
                'icon' => 'bi bi-coin'
            ],
            [
                'name' => 'Empréstimo', 
                'description' => 'Pagamento de empréstimo feito para terceiros', 
                'color' => 'bg-purple', 
                'icon' => 'bi bi-piggy-bank-fill'
            ],
        ];

        $expenseCategories = [
            [
                'name' => 'Supermercado', 
                'description' => 'Gastos com supermercado', 
                'color' => 'bg-orange', 
                'icon' => 'bi bi-cart4'
            ],
            [
                'name' => 'Transporte', 
                'description' => 'Gastos com transporte', 
                'color' => 'bg-red', 
                'icon' => 'bi bi-bus'
            ],
            [
                'name' => 'Casa', 
                'description' => 'Gastos com casa', 
                'color' => 'bg-pink', 
                'icon' => 'bi bi-house'
            ],
        ];

        foreach ($revenueCategories as $category) {
            RevenueCategory::create($category);
        }

        foreach ($expenseCategories as $category) {
            ExpenseCategory::create($category);
        }
    }
}