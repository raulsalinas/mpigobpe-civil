<?php

namespace App\Http\Controllers;

use App\Models\Matrimonio;
use App\Models\Nacimiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class ListadoDeMatrimoniosController extends Controller
{
    public function index(Request $request)
    {

        return view('matrimonios.listado_de_matrimonios', get_defined_vars());
    }

    public function listar(Request $request)
    {
        $data = Matrimonio::withTrashed()->select('matrim.*',
        'ubigeo_marido.nombre as ubigeo_marido',
        'ubigeo_esposa.nombre as ubigeo_esposa',
        'tipregmat.nombre as tipo_registro_matrimonio',
        )
        ->leftJoin('public.ubigeo as ubigeo_marido', 'ubigeo_marido.codigo', '=', 'matrim.ubigeo1')
        ->leftJoin('public.ubigeo as ubigeo_esposa', 'ubigeo_esposa.codigo', '=', 'matrim.ubigeo2')
        ->leftJoin('public.tipregmat', 'tipregmat.codigo', '=', 'matrim.tipo')
        
        ->when((($request->ano_eje) !=null && ($request->ano_eje) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ano_eje = '".$request->ano_eje."'");
        })
        ->when((($request->nro_lib) !=null && ($request->nro_lib) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nro_lib = '" . $request->nro_lib."'");
        })
        ->when((($request->nro_fol) !=null && ($request->nro_fol) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nro_fol = '" . strtoupper($request->nro_fol)."'");
        })
        ->when((($request->ape_mar) !=null && ($request->ape_mar) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ape_mar like '" . strtoupper($request->ape_mar)."%'");
        })
        ->when((($request->nom_mar) !=null && ($request->nom_mar) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nom_mar like '" . strtoupper($request->nom_mar)."%'");
        })
        ->when((($request->ape_esp) !=null && ($request->ape_esp) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ape_esp like '" . strtoupper($request->ape_esp)."%'");
        })
        ->when((($request->nom_esp) !=null && ($request->nom_esp) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nom_esp like '" . strtoupper($request->nom_esp)."%'");
        })
        ->when(($request->fch_cel_desde) , function ($query)  use ($request) {
            return $query->whereRaw("matrim.fch_cel >= '" . $request->fch_cel_desde."'");
        })
        ->when(($request->fch_cel_hasta) !=null , function ($query)  use ($request) {
            return $query->whereRaw("matrim.fch_cel <='" . $request->fch_cel_hasta."'");
        })
        ->when((($request->condic != null)), function ($query)  use ($request) {
            if(in_array($request->condic,[1,2,3])){
                return $query->whereRaw("matrim.condic = '" . $request->condic."'");
            }else{
                if($request->condic==4){ // mostrar registros habilitados
                    return $query->whereRaw("matrim.deleted_at isNull" );
                }else if($request->condic == 5){ // mostrar anulados
                    return $query->whereRaw("matrim.deleted_at notNull" );
                }

            }
        })
        ->when(!isset($request->condic), function ($query) {
            return $query->whereRaw("matrim.deleted_at isNull" );
        })

        ->where('matrim.ano_cel','>',0);

        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) {
            
            
            $btnVer ='<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-primary ver" title="Ver" data-id="'.$data->id.'" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fas fa-eye"></span></button>
            </div>';
            $btnRecuperar ='<div class="btn-group" role="group">
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



}
