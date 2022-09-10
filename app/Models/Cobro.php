<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cobro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.cobros';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
