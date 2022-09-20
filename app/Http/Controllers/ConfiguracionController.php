<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\Defuncion;
use App\Models\Nacimiento;
use App\Models\Ubigeo;
use App\Models\User;
use Carbon\Carbon;
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
        $data = Ubigeo::withTrashed()
        ->when((($request->nombre_filtro) !=null && ($request->nombre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("ubigeo.nombre = '" . $request->nombre_filtro."'");
        });

        return DataTables::of($data)
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="'.$data->id.'" title="Editar" ><span class="fas fa-edit"></span></button>
            </div>';
        })
        ->rawColumns(['accion'])->make(true);
    }

    public function visualizarUbigeo($id){
        $data = Ubigeo::withTrashed()->find($id);
        return $data;

    }

    public function guardarUbigeo(Request $request)
    {
        try {
            $error = "";
            $alerta="";
            $mensaje="";
            $respuesta="";

            if (strlen($request->codigo) >0 || strlen($request->nombre) >0) {
                $ubigeo = new Ubigeo();
                $ubigeo->codigo = $request->codigo;
                $ubigeo->nombre = strtoupper($request->nombre??'');
                $ubigeo->save();

                $respuesta = 'ok';
                $alerta = 'success';
                $mensaje = 'Se ha guardado un nuevo registro';

                
            } else {
                $mensaje = 'Hubo un problema, no se pudo guardar el registro, debe llenar los campos';
                $respuesta = 'warning';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = strlen($request->codigo);
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }

    public function actualizarUbigeo(Request $request)
    {
        try {
            $error = "";
            $alerta="";
            $mensaje="";
            $respuesta="";

            if ($request->id > 0) {
                $ubigeo = Ubigeo::withTrashed()->find($request->id);
                if(isset($ubigeo) && $ubigeo->id>0){
                    $ubigeo->codigo = $request->codigo;
                    $ubigeo->nombre = strtoupper($request->nombre??'');
                    if($request->estado=='ACTIVO'){
                        $ubigeo->deleted_at = null;
                    }else if($request->estado =='INACTIVO'){
                        $ubigeo->deleted_at =new Carbon();
                    }
                    $ubigeo->save();

                    $respuesta = 'ok';
                    $alerta = 'success';
                    $mensaje = 'Se ha actualizado el registro';

                }
            } else {
                $mensaje = 'Hubo un problema, no se pudo actualizar el registro';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }


    public function listarCentroAsistencial(Request $request)
    {
        $data = CentroAsistencial::withTrashed()
        ->when((($request->nombre_filtro) !=null && ($request->nombre_filtro) !=''), function ($query)  use ($request) {
            return $query->whereRaw("cenasi.nombre = '" . $request->nombre_filtro."'");
        });

        return DataTables::of($data)
        ->addColumn('accion', function ($data) { return 
            '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="'.$data->id.'" title="Editar" ><span class="fas fa-edit"></span></button>
            </div>';
        })
        ->rawColumns(['accion'])->make(true);
    }

    public function visualizarCentroAsistencial($id){
        $data = CentroAsistencial::withTrashed()->find($id);
        return $data;

    }

    public function guardarCentroAsistencial(Request $request)
    {
        try {
            $error = "";
            $alerta="";
            $mensaje="";
            $respuesta="";

            if (strlen($request->codigo) >0 || strlen($request->nombre) >0) {
                $centroAsistencial = new CentroAsistencial();
                $centroAsistencial->codigo = $request->codigo;
                $centroAsistencial->nombre = strtoupper($request->nombre??'');
                $centroAsistencial->direccion = strtoupper($request->direccion??'');
                $centroAsistencial->save();

                $respuesta = 'ok';
                $alerta = 'success';
                $mensaje = 'Se ha guardado un nuevo registro';

                
            } else {
                $mensaje = 'Hubo un problema, no se pudo guardar el registro, debe llenar los campos';
                $respuesta = 'warning';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = strlen($request->codigo);
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }
    
    public function actualizarCentroAsistencial(Request $request)
    {
        try {
            $error = "";
            $alerta= "";
            $mensaje= "";
            $respuesta= ""; 

            if ($request->id > 0) {
                $centroAsistencial = CentroAsistencial::withTrashed()->find($request->id);

                if($centroAsistencial->id >0){
                    $centroAsistencial->codigo = $request->codigo;
                    $centroAsistencial->nombre = strtoupper($request->nombre??'');
                    $centroAsistencial->direccion = strtoupper($request->direccion??'');
                    if($request->estado=='ACTIVO'){
                        $centroAsistencial->deleted_at = null;
                    }else if($request->estado =='INACTIVO'){
                        $centroAsistencial->deleted_at =new Carbon();
                    }
                    $centroAsistencial->save();

                    $respuesta = 'ok';
                    $alerta = 'success';
                    $mensaje = 'Se ha actualizado el registro';

                }
            } else {
                $mensaje = 'Hubo un problema, no se pudo actualizar el registro';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }

}
