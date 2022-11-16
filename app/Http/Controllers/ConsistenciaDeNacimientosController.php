<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\TipoRegistro;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NacimientosExport;
use App\Models\Nacimiento;
use PhpParser\JsonDecoder;
ini_set('memory_limit', '-1');
class ConsistenciaDeNacimientosController extends Controller
{
    public function index(Request $request)
    {
 

        $usuarioList = (new ControlDeNacimientosController)->usuarioList();
        $ubigeoList = (new ControlDeNacimientosController)->ubigeoList();
        $controlAsistencialList = (new ControlDeNacimientosController)->controlAsistencialList();
        // $listaTodoLosAños= $this->listaTodoLosAñosDeNacimientos();
        return view('nacimientos.consistencia_de_nacimientos', get_defined_vars());
    }

    // public function listaTodoLosAñosDeNacimientos(){
    //     $data=Nacimiento::where([['nacimi.ano_nac','!=', ''],['nacimi.ano_nac', '!=', null]])->get();
    //     $anoList=[];
    //     foreach ($data as $key => $value) {
    //         if(in_array($value->ano_nac,$anoList)==false){
    //             $anoList[]=$value->ano_nac;
    //         }
    //     }
    //     return $data;
    // }

    public function reporte($extension,$ano_nac,$nro_lib,$sex_nac,$ubigeo,$usuario,$cen_asi,$fch_nac_desde,$fch_nac_hasta)
    {

        $descripcionFiltro="Considerado todos los registros";
        $donde[] = ['nacimi.ano_nac', '!=', null];

        if ($ano_nac != 'SIN_DATA'){
            $descripcionFiltro.=" del año ".$ano_nac;
            $donde[] = ['nacimi.ano_nac', '=', $ano_nac];

        }
        if ($nro_lib != 'SIN_DATA'){
            $descripcionFiltro.=" con Nº de libro ".$nro_lib;
            $donde[] = ['nacimi.nro_lib', '=', $nro_lib];
        }
        if ($sex_nac != 'SIN_DATA'){
            $descripcionFiltro.=" de sexo ".$sex_nac ==1?' masculino':' femenino';
            $donde[] = ['nacimi.sex_nac', '=', $sex_nac];
        }
        if ($ubigeo != 'SIN_DATA'){
            $descripcionFiltro.=" codigo ubigeo ".$ubigeo;
            $donde[] = ['nacimi.ubigeo', '=', $ubigeo];
        }
        if ($usuario != 'SIN_DATA'){
            $descripcionFiltro.=" de usuario ".$usuario;
            $donde[] = ['nacimi.usuario', '=', $usuario];
        }
        if ($cen_asi != 'SIN_DATA'){
            $descripcionFiltro.=" de centro asistencial ".$cen_asi;
            $donde[] = ['nacimi.cen_asi', '=', $cen_asi];
        }
        if ($fch_nac_desde != 'SIN_DATA' && $fch_nac_hasta == 'SIN_DATA'){
            $descripcionFiltro.=" de fecha inicio ".$fch_nac_desde;
            $donde[] = ['nacimi.fch_nac', '>=', $fch_nac_desde];
        }
        if ($fch_nac_hasta != 'SIN_DATA' && $fch_nac_desde == 'SIN_DATA'){
            $descripcionFiltro.=" de fecha fin ".$fch_nac_hasta;
            $donde[] = ['nacimi.fch_nac', '<=', $fch_nac_hasta];
        }
        if ($fch_nac_hasta != 'SIN_DATA' && $fch_nac_desde != 'SIN_DATA'){
            $descripcionFiltro.=" de fecha fin ".$fch_nac_desde." hasta ".$fch_nac_hasta;
            $donde[] = ['nacimi.fch_nac', '>=', $fch_nac_desde];
            $donde[] = ['nacimi.fch_nac', '<=', $fch_nac_hasta];
        }

        $nacimientos = Nacimiento::select('nacimi.*', 
        'sexo.nombre AS sexo_desc',
        'ubigeo.nombre as ubigeo_desc',
        'condic.nombre as condicion_desc'
        )
        ->leftJoin('public.sexo', 'sexo.codigo', '=', 'nacimi.sex_nac')
        ->leftJoin('public.ubigeo', 'ubigeo.codigo', '=', 'nacimi.ubigeo')
        ->leftJoin('public.condic', 'condic.codigo', '=', 'nacimi.condic')
        ->where($donde)
        ->orderBy('nacimi.fch_nac','asc')
        // ->limit(100)
        ->get();

        if($extension == 'pdf'){
            $vista = View::make(
            'nacimientos/imprimir_consistencia_nacimientos',
            compact('nacimientos','descripcionFiltro')
            )->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($vista);
    
            return $pdf->stream();
            return $pdf->download('registro_nacimientos.pdf');

        }
        if($extension=='xls'){
            return Excel::download(new NacimientosExport($nacimientos,$descripcionFiltro), 'nacimientos_export.xlsx');;
        }

        
    }
}
