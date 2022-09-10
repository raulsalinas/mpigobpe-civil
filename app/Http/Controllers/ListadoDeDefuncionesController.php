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
        
        ->when((($request->anio_filtro) !=null && ($request->anio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.ano_des = '".$request->anio_filtro."'");
        })
        ->when((($request->libro_filtro) !=null && ($request->libro_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.nro_lib = '" . $request->libro_filtro."'");
        })
        ->when((($request->folio_filtro) !=null && ($request->folio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.nro_fol = '" . $request->folio_filtro."'");
        })
        ->when((($request->apellido_paterno_filtro) !=null && ($request->apellido_paterno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.ape_pat_de = '" . $request->apellido_paterno_filtro."'");
        })
        ->when((($request->apellido_materno_filtro) !=null && ($request->apellido_materno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.ape_mat_de = '" . $request->apellido_materno_filtro."'");
        })
        ->when((($request->nombre_filtro) !=null && ($request->apellido_materno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("defun.nom_des = '" . $request->apellido_materno_filtro."'");
        })
 
        ->when(((($request->fecha_desde_filtro) !=null && ($request->fecha_desde_filtro) !='') && (($request->fecha_hasta_filtro) ==null || ($request->fecha_hasta_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("defun.fch_des >= '" . $request->fecha_desde_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) ==null || ($request->fecha_desde_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("defun.fch_des <='" . $request->fecha_hasta_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) !=null || ($request->fecha_desde_filtro) !='')), function ($query)  use ($request) {
            return $query->whereBetween("defun.fch_des", [$request->fecha_desde_filtro,$request->fecha_hasta_filtro]);
        })
  
        ->where('defun.ano_des','!=','');

        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-primary ver" data-id="'.$data->id.'" data-año="'.$data->ano_des.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fas fa-eye"></span></button>
            </div>';
        })
        ->addColumn('accion-seleccionar', function ($data) { return 
            '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="'.$data->id.'" data-año="'.$data->ano_des.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" >Seleccionar</button>
            </div>';
        })
        ->rawColumns(['accion','accion-seleccionar'])->make(true);
    }


}
