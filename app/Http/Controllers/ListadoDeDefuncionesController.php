<?php

namespace App\Http\Controllers;

use App\Exports\DescargarListadoDefuncionExcel;
use App\Models\Defuncion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ListadoDeDefuncionesController extends Controller
{
    public function index(Request $request)
    {
        return view('defunciones.listado_de_defunciones', get_defined_vars());
    }

    public function reporteDefuncion($ano_eje,$nro_lib,$nro_fol,$ape_des,$nom_des,$fch_des_desde,$fch_des_hasta,$condic){
        $data = Defuncion::withTrashed()->select('defun.*',
        'tipregdef.nombre as tipo_registro_defuncion',
        'motvos.nombre as motivo_defuncion'
        )
        ->leftJoin('public.tipregdef', 'tipregdef.codigo', '=', 'defun.tipo')
        ->leftJoin('public.motvos', 'motvos.codigo', '=', 'defun.cod_mot')
        
        ->when((($ano_eje) !=null && ($ano_eje) !='SIN_FILTRO'), function ($query)  use ($ano_eje) {
            return $query->whereRaw("defun.ano_eje = '".$ano_eje."'");
        })
        ->when((($nro_lib) !=null && ($nro_lib) !='SIN_FILTRO'), function ($query)  use ($nro_lib) {
            return $query->whereRaw("defun.nro_lib = '" . $nro_lib."'");
        })
        ->when((($nro_fol) !=null && ($nro_fol) !='SIN_FILTRO'), function ($query)  use ($nro_fol) {
            return $query->whereRaw("defun.nro_fol = '" . $nro_fol."'");
        })
        ->when((($ape_des) !=null && ($ape_des) !='SIN_FILTRO'), function ($query)  use ($ape_des) {
            return $query->whereRaw("defun.ape_des like '" . strtoupper($ape_des)."%'");
        })
        ->when((($nom_des) !=null && ($nom_des) !='SIN_FILTRO'), function ($query)  use ($nom_des) {
            return $query->whereRaw("defun.nom_des like '" . strtoupper($nom_des)."%'");
        })
 
        ->when(($fch_des_desde) !=null && ($fch_des_desde) != 'SIN_FILTRO' , function ($query)  use ($fch_des_desde) {
            return $query->whereRaw("defun.fch_des >= '" . $fch_des_desde."'");
        })
        ->when(($fch_des_hasta) !=null && ($fch_des_hasta) !='SIN_FILTRO' , function ($query)  use ($fch_des_hasta) {
            return $query->whereRaw("defun.fch_des <='" . $fch_des_hasta."'");
        })

        ->when((($condic != null) && $condic !='SIN_FILTRO'), function ($query)  use ($condic) {
            if(in_array($condic,[1,2,3])){
                return $query->whereRaw("defun.condic = '" . $condic."'");
            }else{
                if($condic==4){ // mostrar registros habilitados
                    return $query->whereRaw("defun.deleted_at isNull" );
                }else if($condic == 5){ // mostrar anulados
                    return $query->whereRaw("defun.deleted_at notNull" );
                }

            }
        })
        ->when(!isset($condic), function ($query) {
            return $query->whereRaw("defun.deleted_at isNull" );
        })
  
        ->where('defun.ano_des','>',0)->get();

        return $data;
    }

    public function listar(Request $request)
    {        
        $data = Defuncion::withTrashed()->select('defun.*',
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
 
        ->when(($request->fch_des_desde) !=null , function ($query)  use ($request) {
            return $query->whereRaw("defun.fch_des >= '" . $request->fch_des_desde."'");
        })
        ->when(($request->fch_des_hasta) !=null , function ($query)  use ($request) {
            return $query->whereRaw("defun.fch_des <='" . $request->fch_des_hasta."'");
        })

        ->when((($request->condic != null)), function ($query)  use ($request) {
            if(in_array($request->condic,[1,2,3])){
                return $query->whereRaw("defun.condic = '" . $request->condic."'");
            }else{
                if($request->condic==4){ // mostrar registros habilitados
                    return $query->whereRaw("defun.deleted_at isNull" );
                }else if($request->condic == 5){ // mostrar anulados
                    return $query->whereRaw("defun.deleted_at notNull" );
                }

            }
        })
        ->when(!isset($request->condic), function ($query) {
            return $query->whereRaw("defun.deleted_at isNull" );
        })
  
        ->where('defun.ano_des','>',0);

        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) { 
            
            $btnVer = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-primary ver" title="Ver" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fas fa-eye"></span></button>
            </div>';
            $btnRecuperar = '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning recuperar" title="Recuperar" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fa-solid fa-trash-can-arrow-up"></span></button>
            </div>';

            if($data->deleted_at != null && $data->deleted_at != ''){
                
                return $btnVer.$btnRecuperar;
            }else{
                return $btnVer; 
            }
        })
        ->addColumn('accion-seleccionar', function ($data) { return 
            '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" >Seleccionar</button>
            </div>';
        })
        ->rawColumns(['accion','accion-seleccionar'])->make(true);
    }


    public function descargarListadoDefuncionExcel($ano_eje,$nro_lib,$nro_fol,$ape_des,$nom_des,$fch_des_desde,$fch_des_hasta,$condic){

        return Excel::download(new DescargarListadoDefuncionExcel($ano_eje,$nro_lib,$nro_fol,$ape_des,$nom_des,$fch_des_desde,$fch_des_hasta,$condic), 'reporte_defuncion.xlsx');

    }
}
