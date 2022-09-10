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
class ConsistenciaDeNacimientosController extends Controller
{
    public function index(Request $request)
    {
 

        $usuarioList = (new ControlDeNacimientosController)->usuarioList();
        $ubigeoList = (new ControlDeNacimientosController)->ubigeoList();
        $controlAsistencialList = (new ControlDeNacimientosController)->controlAsistencialList();

        return view('nacimientos.consistencia_de_nacimientos', get_defined_vars());
    }
    public function reporteTodoRegistro($ano_nac,$nro_lib,$sex_nac,$ubigeo,$usuario,$cen_asi,$fch_nac_desde,$fch_nac_hasta)
    {

        $descripcionFiltro="Considerado todos los registros";
        $donde = ['nacimi.ano_nac', '!=', ''];

        if ($ano_nac != 'SIN_DATA'){
            $descripcionFiltro.=" del año ".$ano_nac;
            // $donde[] = ['nacimi.ano_nac', '=', $ano_nac];

        }
        if ($nro_lib != 'SIN_DATA'){
            $descripcionFiltro.=" con Nº de libro ".$nro_lib;
            // $donde[] = ['nacimi.nro_lib', '=', $nro_lib];
        }
        if ($sex_nac != 'SIN_DATA'){
            $descripcionFiltro.=" de sexo ".$sex_nac ==1?'masculino':'femenino';
            // $donde[] = ['nacimi.sex_nac', '=', $sex_nac];
        }

        $nacimientos = Nacimiento::select('nacimi.*', 
        'sexo.nombre AS sexo_desc',
        'ubigeo.nombre as ubigeo_desc',
        'condic_nac.nombre as condicion_desc'
        )
        ->leftJoin('public.sexo', 'sexo.codigo', '=', 'nacimi.sex_nac')
        ->leftJoin('public.ubigeo', 'ubigeo.codigo', '=', 'nacimi.ubigeo')
        ->leftJoin('public.condic_nac', 'condic_nac.codigo', '=', 'nacimi.condic_nac')
        ->where([['nacimi.ano_nac', '=', '1997']])
        ->get();

        // $nacimientos = Nacimiento::where([['nacimi.ano_nac', '=', '1997'],['nacimi.nro_lib', '!=', null],['nacimi.nro_fol', '!=', null]])->get();

        $vista = View::make(
            'nacimientos/imprimir_consistencia_nacimientos',
            compact('nacimientos','descripcionFiltro')
        )->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($vista);

        return $pdf->stream();
        return $pdf->download('registro_nacimientos.pdf');

        
    }

    // public function imprimir_pdf($ano_nac,$nro_lib,$sex_nac,$ubigeo,$usuario,$cen_asi,$fch_nac_desde,$fch_nac_hasta)
    // {

    //     $descripcionFiltro="Considerado todos los registros";
    //     $donde = ['nacimi.ano_nac', '!=', ''];

    //     if ($ano_nac != 'SIN_DATA'){
    //         $descripcionFiltro.=" del año ".$ano_nac;
    //         // $donde[] = ['nacimi.ano_nac', '=', $ano_nac];

    //     }
    //     if ($nro_lib != 'SIN_DATA'){
    //         $descripcionFiltro.=" con Nº de libro ".$nro_lib;
    //         // $donde[] = ['nacimi.nro_lib', '=', $nro_lib];
    //     }
    //     if ($sex_nac != 'SIN_DATA'){
    //         $descripcionFiltro.=" de sexo ".$sex_nac ==1?'masculino':'femenino';
    //         // $donde[] = ['nacimi.sex_nac', '=', $sex_nac];
    //     }


    //      $payload = Nacimiento::select('nacimi.*', 
    //     'sexo.nombre AS sexo_desc',
    //     'ubigeo.nombre as ubigeo_desc',
    //     'condic_nac.nombre as condicion_desc'
    //     )
    //     ->leftJoin('public.sexo', 'sexo.codigo', '=', 'nacimi.sex_nac')
    //     ->leftJoin('public.ubigeo', 'ubigeo.codigo', '=', 'nacimi.ubigeo')
    //     ->leftJoin('public.condic_nac', 'condic_nac.codigo', '=', 'nacimi.condic_nac')
    //     ->where('nacimi.ano_nac', '!=', '')
    //     ->get();

  
    //      $now = new \DateTime();
    
    // }
}
