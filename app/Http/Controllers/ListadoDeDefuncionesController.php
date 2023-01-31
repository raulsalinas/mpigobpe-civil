<?php

namespace App\Http\Controllers;

use App\Models\Defuncion;
use App\Models\Nacimiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class ListadoDeDefuncionesController extends Controller
{
    public function index(Request $request)
    {
        return view('defunciones.listado_de_defunciones', get_defined_vars());
    }

    public function listar(Request $request)
    {
        $data = Defuncion::select('defun.*',
        'tipregdef.nombre as tipo_registro_defuncion',
        'motvos.nombre as motivo_defuncion'
        )
        ->leftJoin('public.tipregdef', 'tipregdef.codigo', '=', 'defun.tipo')
        ->leftJoin('public.motvos', 'motvos.codigo', '=', 'defun.cod_mot')
        
        ->when((($request->ano_eje) !=null && ($request->ano_eje) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.ano_eje = '".$request->ano_eje."'");
        })
        ->when((($request->nro_lib) !=null && ($request->nro_lib) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.nro_lib = '" . $request->nro_lib."'");
        })
        ->when((($request->nro_fol) !=null && ($request->nro_fol) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.nro_fol = '" . $request->nro_fol."'");
        })
        ->when((($request->ape_des) !=null && ($request->ape_des) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.ape_des like '" . strtoupper($request->ape_des)."%'");
        })
        ->when((($request->nom_des) !=null && ($request->nom_des) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.nom_des like '" . strtoupper($request->nom_des)."%'");
        })
 
        ->when(((($request->fch_des_desde) !=null && ($request->fch_des_desde) !='') && (($request->fch_des_hasta) ==null || ($request->fch_des_hasta) =='')), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.fch_nac >= '" . $request->fch_des_desde."'");
        })
        ->when(((($request->fch_des_hasta) !=null && ($request->fch_des_hasta) !='') && (($request->fch_des_desde) ==null || ($request->fch_des_desde) =='')), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.fch_nac <='" . $request->fch_des_hasta."'");
        })
        ->when((($request->condic) !=null && ($request->condic) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.condic = '" . $request->condic."'");
        })
  
        ->where('defun.ano_des','>',0);

        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-primary ver" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fas fa-eye"></span></button>
            </div>';
        })
        ->addColumn('accion-seleccionar', function ($data) { return 
            '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" >Seleccionar</button>
            </div>';
        })
        ->rawColumns(['accion','accion-seleccionar'])->make(true);
    }


}
