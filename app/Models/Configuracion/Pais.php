<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion.paises';
    protected $fillable = ['codigo', 'descripcion'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }
}
