<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_expense',
        'user_id',
        'color_id',
        'icon_id'
    ];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }

    public function delete()
    {
        // Удаляем все операции принадлежащие удаляемой категории
        $this->operations()->delete();

        return parent::delete();
    }
}
