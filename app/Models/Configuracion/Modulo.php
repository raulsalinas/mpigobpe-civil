<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modulo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion.modulos';
    protected $fillable = ['descripcion', 'ruta'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
