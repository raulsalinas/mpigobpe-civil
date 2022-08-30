<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distrito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuracion.distritos';
    protected $fillable = ['codigo', 'descripcion', 'provincia_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
