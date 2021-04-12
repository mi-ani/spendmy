<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'category_id'
    ];

    /**
     * Получить категорию, которой принадлежит операция
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
