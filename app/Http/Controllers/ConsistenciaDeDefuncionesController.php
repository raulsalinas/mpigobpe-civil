<?php

namespace App\Http\Controllers;

use App\Models\Defuncion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
ini_set('max_execution_time', 300);
class ConsistenciaDeDefuncionesController extends Controller
{
    public function index(Request $request)
    {
        $tipo =  $request->query('tipo');
        $usuarioList = (new ControlDeNacimientosController)->usuarioList();
        $ubigeoList = (new ControlDeNacimientosController)->ubigeoList();
        $controlAsistencialList = (new ControlDeNacimientosController)->controlAsistencialList();

        return view('defunciones.consistencia_de_defunciones', get_defined_vars());
    }
    
    public function reporte($ano_des,$nro_lib,$usuario,$fch_des_desde,$fch_des_hasta)
    {

        $descripcionFiltro="Considerado todos los registros";
        $donde[] = ['defun.ano_des', '!=', null];

        if ($ano_des != 'SIN_DATA'){
            $descripcionFiltro.=" del año ".$ano_des;
            $donde[] = ['defun.ano_des', '=', $ano_des];

        }
        if ($nro_lib != 'SIN_DATA'){
            $descripcionFiltro.=" con Nº de libro ".$nro_lib;
            $donde[] = ['defun.nro_lib', '=', $nro_lib];
        }
        if ($usuario != 'SIN_DATA'){
            $descripcionFiltro.=" de usuario ".$usuario;
            $donde[] = ['defun.usuario', '=', $usuario];
        }
        if ($fch_des_desde != 'SIN_DATA' && $fch_des_hasta == 'SIN_DATA'){
            $descripcionFiltro.=" de fecha inicio ".$fch_des_desde;
            $donde[] = ['defun.fch_des', '>=', $fch_des_desde];
        }
        if ($fch_des_hasta != 'SIN_DATA' && $fch_des_desde == 'SIN_DATA'){
            $descripcionFiltro.=" de fecha fin ".$fch_des_hasta;
            $donde[] = ['defun.fch_des', '<=', $fch_des_hasta];
        }
        if ($fch_des_hasta != 'SIN_DATA' && $fch_des_desde != 'SIN_DATA'){
            $descripcionFiltro.=" de fecha fin ".$fch_des_desde." hasta ".$fch_des_hasta;
            $donde[] = ['defun.fch_des', '>=', $fch_des_desde];
            $donde[] = ['defun.fch_des', '<=', $fch_des_hasta];
        }

        $defunciones = Defuncion::select('defun.*', 
        'tipregmat.nombre as tipo_registro',
        'motvos.nombre AS motivo',

        )
        ->leftJoin('public.tipregmat', 'tipregmat.codigo', '=', 'defun.cod_reg')
        ->leftJoin('public.motvos', 'motvos.codigo', '=', 'defun.cod_mot')
        ->where($donde)
        ->orderBy('defun.fch_des','asc')
        ->limit(100)
        ->get();

        $vista = View::make(
            'defunciones/imprimir_consistencia_defuncion',
            compact('defunciones','descripcionFiltro')
        )->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($vista);

        return $pdf->stream();
        return $pdf->download('registro_defunciones.pdf');

        
    }
}
