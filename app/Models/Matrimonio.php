<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matrimonio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.matrim';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
