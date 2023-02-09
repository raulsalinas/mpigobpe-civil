<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FichasMatrimonio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.fichas_matrim';

    public function condicion()
    {
        return $this->hasOne('App\Models\Condicion', 'id','condic_id');

    }
}
