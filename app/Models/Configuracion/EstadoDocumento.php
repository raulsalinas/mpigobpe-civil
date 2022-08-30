<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoDocumento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion.estado_documentos';
    protected $fillable = ['descripcion', 'color'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
