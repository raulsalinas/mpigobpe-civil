<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion.roles';
    protected $fillable = ['descripcion', 'modulo_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }
}
