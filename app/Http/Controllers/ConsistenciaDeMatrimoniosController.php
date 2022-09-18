<?php

namespace App\Http\Controllers;

use App\Models\Matrimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
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

    public function reporte($ano_cel,$nro_lib,$usuario,$fch_cel_desde,$fch_cel_hasta)
    {

        $descripcionFiltro="Considerado todos los registros";
        $donde[] = ['matrim.ano_cel', '!=', null];

        if ($ano_cel != 'SIN_DATA'){
            $descripcionFiltro.=" del año ".$ano_cel;
            $donde[] = ['matrim.ano_cel', '=', $ano_cel];

        }
        if ($nro_lib != 'SIN_DATA'){
            $descripcionFiltro.=" con Nº de libro ".$nro_lib;
            $donde[] = ['matrim.nro_lib', '=', $nro_lib];
        }
        if ($usuario != 'SIN_DATA'){
            $descripcionFiltro.=" de usuario ".$usuario;
            $donde[] = ['matrim.usuario', '=', $usuario];
        }
        if ($fch_cel_desde != 'SIN_DATA' && $fch_cel_hasta == 'SIN_DATA'){
            $descripcionFiltro.=" de fecha inicio ".$fch_cel_desde;
            $donde[] = ['matrim.fch_cel', '>=', $fch_cel_desde];
        }
        if ($fch_cel_hasta != 'SIN_DATA' && $fch_cel_desde == 'SIN_DATA'){
            $descripcionFiltro.=" de fecha fin ".$fch_cel_hasta;
            $donde[] = ['matrim.fch_cel', '<=', $fch_cel_hasta];
        }
        if ($fch_cel_hasta != 'SIN_DATA' && $fch_cel_desde != 'SIN_DATA'){
            $descripcionFiltro.=" de fecha fin ".$fch_cel_desde." hasta ".$fch_cel_hasta;
            $donde[] = ['matrim.fch_cel', '>=', $fch_cel_desde];
            $donde[] = ['matrim.fch_cel', '<=', $fch_cel_hasta];
        }

        $matrimonios = Matrimonio::select('matrim.*', 
        'tipregmat.nombre as tipo_registro'
        )
        ->leftJoin('public.tipregmat', 'tipregmat.codigo', '=', 'matrim.cod_reg')
        ->where($donde)
        ->orderBy('matrim.fch_cel','asc')
        ->limit(100)
        ->get();

        $vista = View::make(
            'matrimonios/imprimir_consistencia_matrimonio',
            compact('matrimonios','descripcionFiltro')
        )->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($vista);

        return $pdf->stream();
        return $pdf->download('registro_matrimonios.pdf');

        
    }
}
