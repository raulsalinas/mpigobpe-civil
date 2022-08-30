<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nacimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.nacimi';
    // protected $fillable = ['descripcion', 'simbolo'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
