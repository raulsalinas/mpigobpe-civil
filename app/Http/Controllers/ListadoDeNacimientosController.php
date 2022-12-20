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

        $data = Nacimiento::select('nacimi.*', 
        'sexo.nombre AS sexo_desc',
        'ubigeo.nombre as ubigeo_desc',
        'condic.nombre as condicion_desc'
        )
        ->leftJoin('public.sexo', 'sexo.codigo', '=', 'nacimi.sex_nac')
        ->leftJoin('public.ubigeo', 'ubigeo.codigo', '=', 'nacimi.ubigeo')
        ->leftJoin('public.condic', 'condic.codigo', '=', 'nacimi.condic')
        
        ->when((($request->anio_filtro) !=null && ($request->anio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ano_eje = '".$request->anio_filtro."'");
        })
        ->when((($request->libro_filtro) !=null && ($request->libro_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nro_lib = '" . $request->libro_filtro."'");
        })
        ->when((($request->folio_filtro) !=null && ($request->folio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nro_fol = '" . $request->folio_filtro."'");
        })
        ->when((($request->apellido_paterno_filtro) !=null && ($request->apellido_paterno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_pat_na like '" . strtoupper($request->apellido_paterno_filtro)."%'");
        })
        ->when((($request->apellido_materno_filtro) !=null && ($request->apellido_materno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_mat_na like '" . strtoupper($request->apellido_materno_filtro)."%'");
        })
        ->when((($request->nombres_filtro) !=null && ($request->nombres_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nom_nac like '%" . strtoupper($request->nombres_filtro)."%'");
        })
        ->when((($request->apellido_paterno_padre_filtro) !=null && ($request->apellido_paterno_padre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_pat_pa like '" . strtoupper($request->apellido_paterno_padre_filtro)."%'");
        })
        ->when((($request->apellido_materno_padre_filtro) !=null && ($request->apellido_materno_padre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_mat_pa like '" . strtoupper($request->apellido_materno_padre_filtro)."%'");
        })
        ->when((($request->nombres_padre_filtro) !=null && ($request->nombres_padre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nom_pad like '%" . strtoupper($request->nombres_padre_filtro)."%'");
        })
        ->when((($request->apellido_paterno_madre_filtro) !=null && ($request->apellido_paterno_madre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_pat_ma like '" . strtoupper($request->apellido_paterno_madre_filtro)."%'");
        })
        ->when((($request->apellido_materno_madre_filtro) !=null && ($request->apellido_materno_madre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.ape_mat_ma like '" . strtoupper($request->apellido_materno_madre_filtro)."%'");
        })
        ->when((($request->nombres_madre_filtro) !=null && ($request->nombres_madre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.nom_mad like '%" . strtoupper($request->nombres_madre_filtro)."%'");
        })
        ->when(((($request->fecha_desde_filtro) !=null && ($request->fecha_desde_filtro) !='') && (($request->fecha_hasta_filtro) ==null || ($request->fecha_hasta_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.fch_nac >= '" . $request->fecha_desde_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) ==null || ($request->fecha_desde_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.fch_nac <='" . $request->fecha_hasta_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) !=null || ($request->fecha_desde_filtro) !='')), function ($query)  use ($request) {
            return $query->whereBetween("nacimi.fch_nac", [$request->fecha_desde_filtro,$request->fecha_hasta_filtro]);
        })
        ->when((($request->condicion_filtro) !=null && ($request->condicion_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("nacimi.condic = '" . $request->condicion_filtro."'");
        })
        ->where('nacimi.ano_nac','!=','');

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
