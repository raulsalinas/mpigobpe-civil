<?php

namespace App\Http\Controllers;

use App\Exports\ReporteCobrosExport;
use App\Models\FichasDefuncion;
use App\Models\FichasMatrimonio;
use App\Models\FichasNacimiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class FichaController extends Controller
{
    public function Index(Request $request)
    {
        return view('utilidades.listado_de_fichas', get_defined_vars());
    }

    public function listarFichaNacimientos(Request $request)
    {
        $data = FichasNacimiento::withTrashed()->with("condicion");

        return DataTables::of($data)->make(true);
    }
    public function listarFichaMatrimonios(Request $request)
    {
        $data = FichasMatrimonio::withTrashed()->with("condicion");

        return DataTables::of($data)->make(true);
    }
    public function listarFichaDefunciones(Request $request)
    {
        $data = FichasDefuncion::withTrashed()->with("condicion"); 

        return DataTables::of($data)->make(true);
    }

}
