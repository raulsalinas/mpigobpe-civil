<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CondicionNacimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.condic_naci';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
