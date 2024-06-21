<?php

namespace App\Models\Revenue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'description',
        'value',
        'date',
        'is_fixed',
        'is_received',
    ];

    protected $casts = [
        'date' => 'date',
        'is_fixed' => 'boolean',
        'is_received' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(RevenueCategory::class);
    }   
}