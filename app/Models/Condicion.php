<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condicion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.condic';
    protected $primaryKey = 'id';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
