<?php

namespace App\Http\Controllers;

use App\Exports\ReporteCobrosExport;
use App\Models\Cobro;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ListadoCobrosController extends Controller
{
    public function Index(Request $request)
    {
        return view('utilidades.listado_de_cobros', get_defined_vars());
    }

    public function listar(Request $request)
    {
        $data = Cobro::select('cobros.*',
        'tiprec.nombre as tipo_recibo',
        )
        ->leftJoin('public.tiprec', 'tiprec.codigo', '=', 'cobros.tiprec')        
        ->when((($request->anio_filtro) !=null && ($request->anio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("cobros.ano_cel = '".$request->anio_filtro."'");
        })
        ->when((($request->libro_filtro) !=null && ($request->libro_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("cobros.nro_lib = '" . $request->libro_filtro."'");
        })
        ->when((($request->folio_filtro) !=null && ($request->folio_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("cobros.nro_fol = '" . $request->folio_filtro."'");
        })
        ->when((($request->apellido_paterno_marido_filtro) !=null && ($request->apellido_paterno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("cobros.ape_pat_ma = '" . $request->apellido_paterno_filtro."'");
        })
        ->when((($request->apellido_materno_marido_filtro) !=null && ($request->apellido_materno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("cobros.ape_mat_ma = '" . $request->apellido_materno_filtro."'");
        })
 
        ->when((($request->nombre_esposa_filtro) !=null && ($request->apellido_materno_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("cobros.nom_esp = '" . $request->apellido_materno_filtro."'");
        })
        ->when(((($request->fecha_desde_filtro) !=null && ($request->fecha_desde_filtro) !='') && (($request->fecha_hasta_filtro) ==null || ($request->fecha_hasta_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("cobros.fch_cel >= '" . $request->fecha_desde_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) ==null || ($request->fecha_desde_filtro) =='')), function ($query)  use ($request) {
            return $query->whereRaw("cobros.fch_cel <='" . $request->fecha_hasta_filtro."'");
        })
        ->when(((($request->fecha_hasta_filtro) !=null && ($request->fecha_hasta_filtro) !='') && (($request->fecha_desde_filtro) !=null || ($request->fecha_desde_filtro) !='')), function ($query)  use ($request) {
            return $query->whereBetween("cobros.fch_cel", [$request->fecha_desde_filtro,$request->fecha_hasta_filtro]);
        })
  
        ->where('cobros.ano','!=','');

        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-primary ver" data-id="'.$data->id.'" data-año="'.$data->ano.'" data-libro="'.$data->libro.'" data-folio="'.$data->folio.'" ><span class="fas fa-eye"></span></button>
            </div>';
        })
        ->addColumn('accion-seleccionar', function ($data) { return 
            '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="'.$data->id.'" data-año="'.$data->ano.'" data-libro="'.$data->libro.'" data-folio="'.$data->folio.'" >Seleccionar</button>
            </div>';
        })
        ->rawColumns(['accion','accion-seleccionar'])->make(true);
    }

    public function reporteCobrosExcel(){
        return Excel::download(new ReporteCobrosExport(), 'reporte_cobros.xlsx');


    }

}
