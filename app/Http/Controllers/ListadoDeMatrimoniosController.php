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
        $data = Matrimonio::select('matrim.*',
        'ubigeo_marido.nombre as ubigeo_marido',
        'ubigeo_esposa.nombre as ubigeo_esposa',
        'tipregmat.nombre as tipo_registro_matrimonio',
        )
        ->leftJoin('public.ubigeo as ubigeo_marido', 'ubigeo_marido.codigo', '=', 'matrim.ubigeo1')
        ->leftJoin('public.ubigeo as ubigeo_esposa', 'ubigeo_esposa.codigo', '=', 'matrim.ubigeo2')
        ->leftJoin('public.tipregmat', 'tipregmat.codigo', '=', 'matrim.tipo')
        
        ->when((($request->anio_filtro) !=null && ($request->anio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ano_cel = '".$request->anio_filtro."'");
        })
        ->when((($request->libro_filtro) !=null && ($request->libro_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nro_lib = '" . $request->libro_filtro."'");
        })
        ->when((($request->folio_filtro) !=null && ($request->folio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nro_fol = '" . strtoupper($request->folio_filtro)."'");
        })
        ->when((($request->apellido_paterno_marido_filtro) !=null && ($request->apellido_paterno_marido_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ape_pat_ma = '" . strtoupper($request->apellido_paterno_marido_filtro)."'");
        })
        ->when((($request->apellido_materno_marido_filtro) !=null && ($request->apellido_materno_marido_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ape_mat_ma = '" . strtoupper($request->apellido_materno_marido_filtro)."'");
        })
        ->when((($request->nombre_marido_filtro) !=null && ($request->nombre_marido_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nom_mar = '" . strtoupper($request->nombre_marido_filtro)."'");
        })
        ->when((($request->apellido_paterno_esposa_filtro) !=null && ($request->apellido_paterno_esposa_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ape_pat_es = '" . strtoupper($request->apellido_paterno_esposa_filtro)."'");
        })
        ->when((($request->apellido_materno_esposa_filtro) !=null && ($request->apellido_materno_esposa_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.ape_mat_es = '" . strtoupper($request->apellido_materno_esposa_filtro)."'");
        })
        ->when((($request->nombre_esposa_filtro) !=null && ($request->nombre_esposa_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("matrim.nom_esp = '" . strtoupper($request->nombre_esposa_filtro)."'");
        })
        ->when(((($request->fecha_desde_filtro) !=null && ($request->fecha_desde_filtro) !='') && (($request->fecha_hasta_filtro) ==null || ($request->fecha_hasta_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("matrim.fch_cel >= '" . $request->fecha_desde_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) ==null || ($request->fecha_desde_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("matrim.fch_cel <='" . $request->fecha_hasta_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) !=null || ($request->fecha_desde_filtro) !='')), function ($query)  use ($request) {
            return $query->whereBetween("matrim.fch_cel", [$request->fecha_desde_filtro,$request->fecha_hasta_filtro]);
        })
  
        ->where('matrim.ano_cel','!=','');

        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-primary ver" data-id="'.$data->id.'" data-año="'.$data->ano_cel.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fas fa-eye"></span></button>
            </div>';
        })
        ->addColumn('accion-seleccionar', function ($data) { return 
            '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="'.$data->id.'" data-año="'.$data->ano_cel.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" >Seleccionar</button>
            </div>';
        })
        ->rawColumns(['accion','accion-seleccionar'])->make(true);
    }



}
