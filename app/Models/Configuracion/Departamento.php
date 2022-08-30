<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion.paises';
    protected $fillable = ['codigo', 'descripcion', 'pais_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function provincias()
    {
        return $this->hasMany(Provincia::class);
    }
}
