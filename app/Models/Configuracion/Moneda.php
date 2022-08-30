<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moneda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion.monedas';
    protected $fillable = ['descripcion', 'simbolo'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
