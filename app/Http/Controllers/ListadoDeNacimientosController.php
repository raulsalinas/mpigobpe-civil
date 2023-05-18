<?php

namespace App\Http\Controllers;

use App\Exports\descargarListadoNacimientoExcel;
use App\Models\Nacimiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ListadoDeNacimientosController extends Controller
{
    public function index(Request $request)
    {


        // $tipoDocumento = DocumentoIdentidad::all();
        // $estadoCivil = EstadoCivil::all();
    
        return view('nacimientos.listado_de_nacimientos', get_defined_vars());
    }

    public function reporteNacimiento($ano_eje ,$nro_lib ,$nro_fol ,$ano_nac ,$nom_nac ,$ape_pat_nac ,$ape_mat_nac ,$nom_pad ,$ape_pad ,$nom_mad ,$ape_mad ,$fch_nac_desde ,$fch_nac_hasta ,$condic){
        $data = Nacimiento::withTrashed()->select('nacimi.*', 
        'ubigeo.nombre as ubigeo_desc',
        'condic.nombre as condicion_desc'
        )
        ->leftJoin('public.ubigeo', 'ubigeo.codigo', '=', 'nacimi.ubigeo')
        ->leftJoin('public.condic', 'condic.codigo', '=', 'nacimi.condic')
        
        ->when((($ano_eje) !=null && ($ano_eje) !='SIN_FILTRO'), function ($query)  use ($ano_eje) {
            return $query->whereRaw("nacimi.ano_eje = '".$ano_eje."'");
        })
        ->when((($nro_lib) !=null && ($nro_lib) !='SIN_FILTRO'), function ($query)  use ($nro_lib) {
            return $query->whereRaw("nacimi.nro_lib = '" . $nro_lib."'");
        })
        ->when((($nro_fol) !=null && ($nro_fol) !='SIN_FILTRO'), function ($query)  use ($nro_fol) {
            return $query->whereRaw("nacimi.nro_fol = '" . $nro_fol."'");
        })
        ->when((($ano_nac) !=null && ($ano_nac) !='SIN_FILTRO'), function ($query)  use ($ano_nac) {
            return $query->whereRaw("nacimi.ano_nac = '" . $ano_nac."'");
        })
        ->when((($nom_nac) !=null && ($nom_nac) !='SIN_FILTRO'), function ($query)  use ($nom_nac) {
            return $query->whereRaw("nacimi.nom_nac like '" . strtoupper($nom_nac)."%'");
        }) 
        ->when((($ape_pat_nac) !=null && ($ape_pat_nac) !='SIN_FILTRO'), function ($query)  use ($ape_pat_nac) {
            return $query->whereRaw("nacimi.ape_pat_nac like '" . strtoupper($ape_pat_nac)."%'");
        }) 
        ->when((($ape_mat_nac) !=null && ($ape_mat_nac) !='SIN_FILTRO'), function ($query)  use ($ape_mat_nac) {
            return $query->whereRaw("nacimi.ape_mat_nac like '" . strtoupper($ape_mat_nac)."%'");
        }) 
        ->when((($nom_pad) !=null && ($nom_pad) !='SIN_FILTRO'), function ($query)  use ($nom_pad) {
            return $query->whereRaw("nacimi.nom_pad like '" . strtoupper($nom_pad)."%'");
        }) 
        ->when((($ape_pad) !=null && ($ape_pad) !='SIN_FILTRO'), function ($query)  use ($ape_pad) {
            return $query->whereRaw("nacimi.ape_pad like '" . strtoupper($ape_pad)."%'");
        }) 
        ->when((($nom_mad) !=null && ($nom_mad) !='SIN_FILTRO'), function ($query)  use ($nom_mad) {
            return $query->whereRaw("nacimi.nom_mad like '" . strtoupper($nom_mad)."%'");
        }) 
        ->when((($ape_mad) !=null && ($ape_mad) !='SIN_FILTRO'), function ($query)  use ($ape_mad) {
            return $query->whereRaw("nacimi.ape_mad like '" . strtoupper($ape_mad)."%'");
        }) 
        ->when(($fch_nac_desde) !=null && ($fch_nac_desde) !='SIN_FILTRO' , function ($query)  use ($fch_nac_desde) {
            return $query->whereRaw("nacimi.fch_nac >= '" . $fch_nac_desde."'");
        })
        ->when(($fch_nac_hasta) !=null && ($fch_nac_hasta) !='SIN_FILTRO' , function ($query)  use ($fch_nac_hasta) {
            return $query->whereRaw("nacimi.fch_nac <='" . $fch_nac_hasta."'");
        })
        
        ->when((($condic != null) && ($condic != 'SIN_FILTRO')), function ($query)  use ($condic) {
            if(in_array($condic,[1,2,3])){
                return $query->whereRaw("nacimi.condic = '" . $condic."'");
            }else{
                if($condic==4){ // mostrar registros habilitados
                    return $query->whereRaw("nacimi.deleted_at isNull" );
                }else if($condic == 5){ // mostrar anulados
                    return $query->whereRaw("nacimi.deleted_at notNull" );
                }

            }
        })
        ->when(!isset($condic), function ($query) {
            return $query->whereRaw("nacimi.deleted_at isNull" );
        })
        
        ->where('nacimi.ano_nac','>',0)->get();

        return $data;
    }


    public function listar(Request $request)
    {

        $data = Nacimiento::withTrashed()->select('nacimi.*', 
        'ubigeo.nombre as ubigeo_desc',
        'condic.nombre as condicion_desc'
        )
        ->leftJoin('public.ubigeo', 'ubigeo.codigo', '=', 'nacimi.ubigeo')
        ->leftJoin('public.condic', 'condic.codigo', '=', 'nacimi.condic')
        
        ->when((($request->ano_eje) !=null && ($request->ano_eje) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ano_eje = '".$request->ano_eje."'");
        })
        ->when((($request->nro_lib) !=null && ($request->nro_lib) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nro_lib = '" . $request->nro_lib."'");
        })
        ->when((($request->nro_fol) !=null && ($request->nro_fol) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nro_fol = '" . $request->nro_fol."'");
        })
        ->when((($request->ano_nac) !=null && ($request->ano_nac) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ano_nac = '" . $request->ano_nac."'");
        })
        ->when((($request->nom_nac) !=null && ($request->nom_nac) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nom_nac like '" . strtoupper($request->nom_nac)."%'");
        }) 
        ->when((($request->ape_pat_nac) !=null && ($request->ape_pat_nac) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_pat_nac like '" . strtoupper($request->ape_pat_nac)."%'");
        }) 
        ->when((($request->ape_mat_nac) !=null && ($request->ape_mat_nac) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_mat_nac like '" . strtoupper($request->ape_mat_nac)."%'");
        }) 
        ->when((($request->nom_pad) !=null && ($request->nom_pad) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nom_pad like '" . strtoupper($request->nom_pad)."%'");
        }) 
        ->when((($request->ape_pad) !=null && ($request->ape_pad) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_pad like '" . strtoupper($request->ape_pad)."%'");
        }) 
        ->when((($request->nom_mad) !=null && ($request->nom_mad) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nom_mad like '" . strtoupper($request->nom_mad)."%'");
        }) 
        ->when((($request->ape_mad) !=null && ($request->ape_mad) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_mad like '" . strtoupper($request->ape_mad)."%'");
        }) 
        ->when(($request->fch_nac_desde) !=null , function ($query)  use ($request) {
            return $query->whereRaw("nacimi.fch_nac >= '" . $request->fch_nac_desde."'");
        })
        ->when(($request->fch_nac_hasta) !=null , function ($query)  use ($request) {
            return $query->whereRaw("nacimi.fch_nac <='" . $request->fch_nac_hasta."'");
        })
        
        ->when((($request->condic != null)), function ($query)  use ($request) {
            if(in_array($request->condic,[1,2,3])){
                return $query->whereRaw("nacimi.condic = '" . $request->condic."'");
            }else{
                if($request->condic==4){ // mostrar registros habilitados
                    return $query->whereRaw("nacimi.deleted_at isNull" );
                }else if($request->condic == 5){ // mostrar anulados
                    return $query->whereRaw("nacimi.deleted_at notNull" );
                }

            }
        })
        ->when(!isset($request->condic), function ($query) {
            return $query->whereRaw("nacimi.deleted_at isNull" );
        })
        
        ->where('nacimi.ano_nac','>',0);

        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) { 
            $btnVer = '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-primary ver" title="Ver" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fas fa-eye"></span></button>
        </div>';
            $btnRecuperar = '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-warning recuperar" title="Restaurar" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fa-solid fa-trash-can-arrow-up"></span></button>
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

    function descargarListadoNacimientoExcel($ano_eje ,$nro_lib ,$nro_fol ,$ano_nac ,$nom_nac ,$ape_pat_nac ,$ape_mat_nac ,$nom_pad ,$ape_pad ,$nom_mad ,$ape_mad ,$fch_nac_desde ,$fch_nac_hasta ,$condic){

        return Excel::download(new descargarListadoNacimientoExcel($ano_eje ,$nro_lib ,$nro_fol ,$ano_nac ,$nom_nac ,$ape_pat_nac ,$ape_mat_nac ,$nom_pad ,$ape_pad ,$nom_mad ,$ape_mad ,$fch_nac_desde ,$fch_nac_hasta ,$condic), 'reporte_nacimiento.xlsx');

    }
}
