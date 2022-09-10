<?php

namespace App\Http\Controllers;

use App\Models\Nacimiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;

class ControlDeDefuncionesController extends Controller
{
    public function index(Request $request)
    {

        $usuarioList = (new ControlDeNacimientosController)->usuarioList();
        $ubigeoList = (new ControlDeNacimientosController)->ubigeoList();
        $usuario = Auth::user()->usuario;
        $tipoRegistroList = (new ControlDeNacimientosController)->tipoRegistroList();

        return view('defunciones.control_de_defunciones', get_defined_vars());
    }

  



}
