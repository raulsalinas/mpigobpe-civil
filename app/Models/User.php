<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Nombre de la tabla, Schema especifico para PGSQL
     */
    protected $table = 'public.usuarios';

    /**
     * Atributos visibles para el Modelo
     */
    protected $fillable = ['usuario', 'correo', 'password', 'nombre_largo', 'nombre_corto'];

    /**
     * Atributos ocultos para el Modelo
     */
    protected $hidden = ['password', 'remember_token'];
}
