<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recibo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.recibo';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
