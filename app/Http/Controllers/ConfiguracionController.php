<?php

namespace App\Http\Controllers;

use App\Models\Defuncion;
use App\Models\Nacimiento;
use App\Models\Ubigeo;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class ConfiguracionController extends Controller
{
    public function gestionarUsuariosIndex(Request $request)
    {
        return view('configuracion.gestionar_usuarios', get_defined_vars());
    }
    public function maestrosIndex(Request $request)
    {
        return view('configuracion.maestros', get_defined_vars());
    }

    public function listarUsuarios(Request $request)
    {
        $data = User::select("usuarios.*")->when((($request->anio_filtro) !=null && ($request->anio_filtro) !=''), function ($query)  use ($request) {
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
        })->where('usuarios.usuario','!=',"");
  
 
        return DataTables::of($data)
        // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="'.$data->id.'" ><span class="fas fa-edit"></span></button>
            </div>';
        })
        ->addColumn('accion-seleccionar', function ($data) { return 
            '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="'.$data->id.'" >Seleccionar</button>
            </div>';
        })
        ->rawColumns(['accion','accion-seleccionar'])->make(true);
    }

    public function listarUbigeo(Request $request)
    {
        $data = Ubigeo::select("ubigeo.*")
        ->when((($request->nombre_filtro) !=null && ($request->nombre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("ubigeo.nombre = '" . $request->nombre_filtro."'");
        });

        return DataTables::of($data)
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="'.$data->id.'" ><span class="fas fa-edit"></span></button>
            </div>';
        })
        ->addColumn('accion-seleccionar', function ($data) { return 
            '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="'.$data->id.'" >Seleccionar</button>
            </div>';
        })
        ->rawColumns(['accion','accion-seleccionar'])->make(true);
    }

}
