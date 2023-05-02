<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nacimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.nacimi';
    protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function condicion()
    {
        return $this->hasOne('App\Models\Condicion', 'id','condic');

    }
}
