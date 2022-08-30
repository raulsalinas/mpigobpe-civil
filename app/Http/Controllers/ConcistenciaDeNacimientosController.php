<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\Nacimiento;
use App\Models\TipoRegistro;
use App\Models\Ubigeo;
use Illuminate\Http\Request;

class ConcistenciaDeNacimientosController extends Controller
{
    public function index(Request $request)
    {

        return view('nacimientos.concistencia_de_nacimientos', get_defined_vars());
    }
}
