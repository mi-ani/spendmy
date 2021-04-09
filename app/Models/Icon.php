<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string path
 */

class Icon extends Model
{
    use HasFactory;

    protected $fillable = ['path'];
}
