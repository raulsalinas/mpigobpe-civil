<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\Nacimiento;
use App\Models\TipoRegistro;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use PhpParser\JsonDecoder;
ini_set('max_execution_time', 300);
class ConsistenciaDeMatrimoniosController extends Controller
{
    public function index(Request $request)
    {

        $usuarioList = (new ControlDeNacimientosController)->usuarioList();
        $ubigeoList = (new ControlDeNacimientosController)->ubigeoList();
        $controlAsistencialList = (new ControlDeNacimientosController)->controlAsistencialList();

        return view('matrimonios.consistencia_de_matrimonios', get_defined_vars());
    }

}
