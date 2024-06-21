<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Expense\ExpenseCategory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'description',
        'value',
        'date',
        'is_fixed',
        'is_paid',
    ];

    protected $casts = [
        'date' => 'date',
        'is_fixed' => 'boolean',
        'is_paid' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }   
}