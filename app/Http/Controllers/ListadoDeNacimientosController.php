<?php

namespace App\Http\Controllers;

use App\Models\Nacimiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class ListadoDeNacimientosController extends Controller
{
    public function index(Request $request)
    {


        // $tipoDocumento = DocumentoIdentidad::all();
        // $estadoCivil = EstadoCivil::all();
    
        return view('nacimientos.listado_de_nacimientos', get_defined_vars());
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



}
