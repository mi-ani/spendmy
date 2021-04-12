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

    /**
     * Получить операции принадлежащие категории
    */
    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    /**
     * Получить цвет, которому принадлежит категория
    */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Получить иконку, которой принадлежит категория
    */
    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }

    /**
     * Получить пользователя, которому принадлежит категория
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Переопределям метод удаления модели
    */
    public function delete()
    {
        // Удаляем все операции принадлежащие удаляемой категории
        $this->operations()->delete();

        return parent::delete();
    }
}
