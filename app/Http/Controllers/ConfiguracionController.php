<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\Defuncion;
use App\Models\FichasDefuncion;
use App\Models\FichasMatrimonio;
use App\Models\FichasNacimiento;
use App\Models\MotivoDefuncion;
use App\Models\Nacimiento;
use App\Models\TipoRegistro;
use App\Models\Ubigeo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function gestionarUsuariosIndex(Request $request)
    {
        if (Auth::user()->es_administrador == true) {

            return view('configuracion.gestionar_usuarios', get_defined_vars());
        } else {
            return view('bloqueo', get_defined_vars());
        }
    }
    public function maestrosIndex(Request $request)
    {
        if (Auth::user()->es_administrador == true) {

            return view('configuracion.maestros', get_defined_vars());
        } else {
            return view('bloqueo', get_defined_vars());
        }
    }

    public function listarUsuarios(Request $request)
    {
        $data = User::select("usuarios.*")->when((($request->anio_filtro) != null && ($request->anio_filtro) != ''), function ($query)  use ($request) {
            return $query->whereRaw("defun.ano_des = '" . $request->anio_filtro . "'");
        })
            ->when((($request->libro_filtro) != null && ($request->libro_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("defun.nro_lib = '" . $request->libro_filtro . "'");
            })
            ->when((($request->folio_filtro) != null && ($request->folio_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("defun.nro_fol = '" . $request->folio_filtro . "'");
            })
            ->when((($request->apellido_paterno_filtro) != null && ($request->apellido_paterno_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("defun.ape_pat_de = '" . $request->apellido_paterno_filtro . "'");
            })
            ->when((($request->apellido_materno_filtro) != null && ($request->apellido_materno_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("defun.ape_mat_de = '" . $request->apellido_materno_filtro . "'");
            })
            ->when((($request->nombre_filtro) != null && ($request->apellido_materno_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("defun.nom_des = '" . $request->apellido_materno_filtro . "'");
            })

            ->when(((($request->fecha_desde_filtro) != null && ($request->fecha_desde_filtro) != '') && (($request->fecha_hasta_filtro) == null || ($request->fecha_hasta_filtro) == '')), function ($query)  use ($request) {
                return $query->whereRaw("defun.fch_des >= '" . $request->fecha_desde_filtro . "'");
            })
            ->when(((($request->fecha_hasta_filtro) != null && ($request->fecha_hasta_filtro) != '') && (($request->fecha_desde_filtro) == null || ($request->fecha_desde_filtro) == '')), function ($query)  use ($request) {
                return $query->whereRaw("defun.fch_des <='" . $request->fecha_hasta_filtro . "'");
            })
            ->when(((($request->fecha_hasta_filtro) != null && ($request->fecha_hasta_filtro) != '') && (($request->fecha_desde_filtro) != null || ($request->fecha_desde_filtro) != '')), function ($query)  use ($request) {
                return $query->whereBetween("defun.fch_des", [$request->fecha_desde_filtro, $request->fecha_hasta_filtro]);
            })->where('usuarios.usuario', '!=', "");


        return DataTables::of($data)
            // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
            ->addColumn('accion', function ($data) {
                return
                    '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="' . $data->id . '" ><span class="fas fa-edit"></span></button>
            </div>';
            })
            ->addColumn('accion-seleccionar', function ($data) {
                return
                    '<div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-success seleccionar" data-id="' . $data->id . '" >Seleccionar</button>
            </div>';
            })
            ->rawColumns(['accion', 'accion-seleccionar'])->make(true);
    }

    public function visualizarUsuario($id)
    {
        $data = User::withTrashed()->find($id);
        return $data;
    }

    public function guardarUsuario(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if (strlen($request->usuario) > 0 || strlen($request->password) > 0) {
                $usuario = new User();
                $usuario->usuario = $request->usuario;
                $usuario->nombre_largo = $request->nombre_largo;
                $usuario->nombre_corto = $request->nombre_corto;
                $usuario->correo = $request->correo;
                $usuario->password = Hash::make($request->password);
                $usuario->es_administrador = (isset($request->es_administrador) == true) ? true : false;
                $usuario->save();

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

    public function actualizarUsuario(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if ($request->id > 0) {
                $usuario = User::withTrashed()->find($request->id);
                if (isset($usuario) && $usuario->id > 0) {
                    $usuario->usuario = $request->usuario;
                    $usuario->nombre_largo = $request->nombre_largo;
                    $usuario->nombre_corto = $request->nombre_corto;
                    $usuario->correo = $request->correo;
                    $usuario->password = Hash::make($request->password);
                    $usuario->es_administrador = (isset($request->es_administrador) == true) ? true : false;


                    if ($request->estado == 'ACTIVO') {
                        $usuario->deleted_at = null;
                    } else if ($request->estado == 'INACTIVO') {
                        $usuario->deleted_at = new Carbon();
                    }
                    $usuario->save();

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

    public function listarUbigeo(Request $request)
    {
        $data = Ubigeo::withTrashed()
            ->when((($request->nombre_filtro) != null && ($request->nombre_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("ubigeo.nombre = '" . $request->nombre_filtro . "'");
            });

        return DataTables::of($data)
            ->addColumn('accion', function ($data) {
                return
                    '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="' . $data->id . '" title="Editar" ><span class="fas fa-edit"></span></button>
            </div>';
            })
            ->rawColumns(['accion'])->make(true);
    }

    public function visualizarUbigeo($id)
    {
        $data = Ubigeo::withTrashed()->find($id);
        return $data;
    }

    public function guardarUbigeo(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if (strlen($request->codigo) > 0 || strlen($request->nombre) > 0) {
                $ubigeo = new Ubigeo();
                $ubigeo->codigo = $request->codigo;
                $ubigeo->nombre = strtoupper($request->nombre ?? '');
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
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if ($request->id > 0) {
                $ubigeo = Ubigeo::withTrashed()->find($request->id);
                if (isset($ubigeo) && $ubigeo->id > 0) {
                    $ubigeo->codigo = $request->codigo;
                    $ubigeo->nombre = strtoupper($request->nombre ?? '');
                    if ($request->estado == 'ACTIVO') {
                        $ubigeo->deleted_at = null;
                    } else if ($request->estado == 'INACTIVO') {
                        $ubigeo->deleted_at = new Carbon();
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
            ->when((($request->nombre_filtro) != null && ($request->nombre_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("cenasi.nombre = '" . $request->nombre_filtro . "'");
            });

        return DataTables::of($data)
            ->addColumn('accion', function ($data) {
                return
                    '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="' . $data->id . '" title="Editar" ><span class="fas fa-edit"></span></button>
            </div>';
            })
            ->rawColumns(['accion'])->make(true);
    }

    public function visualizarCentroAsistencial($id)
    {
        $data = CentroAsistencial::withTrashed()->find($id);
        return $data;
    }

    public function guardarCentroAsistencial(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if (strlen($request->codigo) > 0 || strlen($request->nombre) > 0) {
                $centroAsistencial = new CentroAsistencial();
                $centroAsistencial->codigo = $request->codigo;
                $centroAsistencial->nombre = strtoupper($request->nombre ?? '');
                $centroAsistencial->direccion = strtoupper($request->direccion ?? '');
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
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if ($request->id > 0) {
                $centroAsistencial = CentroAsistencial::withTrashed()->find($request->id);

                if ($centroAsistencial->id > 0) {
                    $centroAsistencial->codigo = $request->codigo;
                    $centroAsistencial->nombre = strtoupper($request->nombre ?? '');
                    $centroAsistencial->direccion = strtoupper($request->direccion ?? '');
                    if ($request->estado == 'ACTIVO') {
                        $centroAsistencial->deleted_at = null;
                    } else if ($request->estado == 'INACTIVO') {
                        $centroAsistencial->deleted_at = new Carbon();
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

    public function listarTipoRegistro(Request $request)
    {
        $data = TipoRegistro::withTrashed()
            ->when((($request->nombre_filtro) != null && ($request->nombre_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("cenasi.nombre = '" . $request->nombre_filtro . "'");
            });

        return DataTables::of($data)
            ->addColumn('accion', function ($data) {
                return
                    '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="' . $data->id . '" title="Editar" ><span class="fas fa-edit"></span></button>
            </div>';
            })
            ->rawColumns(['accion'])->make(true);
    }

    public function visualizarTipoRegistro($id)
    {
        $data = TipoRegistro::withTrashed()->find($id);
        return $data;
    }

    public function guardarTipoRegistro(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if (strlen($request->codigo) > 0 || strlen($request->nombre) > 0) {
                $centroAsistencial = new TipoRegistro();
                $centroAsistencial->codigo = $request->codigo;
                $centroAsistencial->nombre = strtoupper($request->nombre ?? '');
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

    public function actualizarTipoRegistro(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if ($request->id > 0) {
                $tipoRegistro = TipoRegistro::withTrashed()->find($request->id);

                if ($tipoRegistro->id > 0) {
                    $tipoRegistro->codigo = $request->codigo;
                    $tipoRegistro->nombre = strtoupper($request->nombre ?? '');
                    if ($request->estado == 'ACTIVO') {
                        $tipoRegistro->deleted_at = null;
                    } else if ($request->estado == 'INACTIVO') {
                        $tipoRegistro->deleted_at = new Carbon();
                    }
                    $tipoRegistro->save();

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


    public function listarMotivoDefuncion(Request $request)
    {
        $data = MotivoDefuncion::withTrashed()
            ->when((($request->nombre_filtro) != null && ($request->nombre_filtro) != ''), function ($query)  use ($request) {
                return $query->whereRaw("cenasi.nombre = '" . $request->nombre_filtro . "'");
            });

        return DataTables::of($data)
            ->addColumn('accion', function ($data) {
                return
                    '<div class="btn-group" role="group">
                <button type="button" class="btn btn-xs btn-warning editar" data-id="' . $data->id . '" title="Editar" ><span class="fas fa-edit"></span></button>
            </div>';
            })
            ->rawColumns(['accion'])->make(true);
    }

    public function visualizarMotivoDefuncion($id)
    {
        $data = MotivoDefuncion::withTrashed()->find($id);
        return $data;
    }

    public function guardarMotivoDefuncion(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if (strlen($request->codigo) > 0 || strlen($request->nombre) > 0) {
                $motivoDefuncion = new MotivoDefuncion();
                $motivoDefuncion->codigo = $request->codigo;
                $motivoDefuncion->nombre = strtoupper($request->nombre ?? '');
                $motivoDefuncion->save();

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

    public function actualizarMotivoDefuncion(Request $request)
    {
        try {
            $error = "";
            $alerta = "";
            $mensaje = "";
            $respuesta = "";

            if ($request->id > 0) {
                $motivoDefuncion = MotivoDefuncion::withTrashed()->find($request->id);

                if ($motivoDefuncion->id > 0) {
                    $motivoDefuncion->codigo = $request->codigo;
                    $motivoDefuncion->nombre = strtoupper($request->nombre ?? '');
                    if ($request->estado == 'ACTIVO') {
                        $motivoDefuncion->deleted_at = null;
                    } else if ($request->estado == 'INACTIVO') {
                        $motivoDefuncion->deleted_at = new Carbon();
                    }
                    $motivoDefuncion->save();

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

    // public function indexarFichasNacimientoOrdinarias()
    // {
    //     $FichaOrdinariaNacimientoList = Storage::disk('fichas-ordinarias-nacim')->allFiles();
    //     foreach ($FichaOrdinariaNacimientoList as $key => $fichaOrdinariaNacim) {
    //         $ficha = new FichasNacimiento();
    //         $ficha->condic_id = 1;
    //         $ficha->nombre_completo = $fichaOrdinariaNacim;
    //         $ficha->nombre_sin_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_FILENAME);
    //         $ficha->nombre_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_EXTENSION);
    //         $ficha->ruta = '/fichas/ordinarias/nacim/' . $fichaOrdinariaNacim;
    //         $ficha->estado = 1;
    //         $ficha->save();
    //     }

    //     return "Se termino de indexar todas las fichas";
    // }
    // public function indexarFichasNacimientoExtraordinarias()
    // {
    //     $FichaOrdinariaNacimientoList = Storage::disk('fichas-extraordinarias-nacim')->allFiles();
    //     foreach ($FichaOrdinariaNacimientoList as $key => $fichaOrdinariaNacim) {
    //         $ficha = new FichasNacimiento();
    //         $ficha->condic_id = 2;
    //         $ficha->nombre_completo = $fichaOrdinariaNacim;
    //         $ficha->nombre_sin_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_FILENAME);
    //         $ficha->nombre_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_EXTENSION);
    //         $ficha->ruta = '/fichas/extraordiarias/nacim/' . $fichaOrdinariaNacim;
    //         $ficha->estado = 1;
    //         $ficha->save();
    //     }

    //     return "Se termino de indexar todas las fichas";
    // }

    // public function registrarFichasNacimientoOrdinarias()
    // {
    //     $nacimientosOrdinarios= Nacimiento::where("condic",1)->get();
    //     $fichas=[];
    //     foreach ($nacimientosOrdinarios as $keyr => $r) {
    //         $fichas= FichasNacimiento::where([['nombre_sin_extension',$r->ano_nac.$r->nro_fol],['condic_id',1]])
    //         ->get();
    //         foreach ($fichas as $keyf => $f) {
    //         $ficha = FichasNacimiento::where([['id',$f->id],['condic_id',1]])->first();
    //         if(($ficha)){
    //             $ficha->nacimi_id = $r->id;
    //             $ficha->save();
    //         }
    //         }
    //     }
    //     return "Se termino de registrar la fichas que coinciden con el código del registro";
    // }
    // public function registrarFichasNacimientoOrdinariasA()
    // {
    //     $nacimientosOrdinarios= Nacimiento::where("condic",1)->get();
    //     $fichas=[];
    //     foreach ($nacimientosOrdinarios as $keyr => $r) {
    //         $fichas= FichasNacimiento::where([['nombre_sin_extension',$r->ano_nac.$r->nro_fol.'A'],['condic_id',1]])
    //         ->get();
    //         foreach ($fichas as $keyf => $f) {
    //         $ficha = FichasNacimiento::where([['id',$f->id],['condic_id',1]])->first();
    //         if(($ficha)){
    //             $ficha->nacimi_id = $r->id;
    //             $ficha->save();
    //         }
    //         }
    //     }
    //     return "Se termino de registrar la fichas A que coinciden con el código del registro";
    // }
    // public function registrarFichasNacimientoOrdinariasB()
    // {
    //     $nacimientosOrdinarios= Nacimiento::where("condic",1)->get();
    //     $fichas=[];
    //     foreach ($nacimientosOrdinarios as $keyr => $r) {
    //         $fichas= FichasNacimiento::where([['nombre_sin_extension',$r->ano_nac.$r->nro_fol.'B'],['condic_id',1]])
    //         ->get();
    //         foreach ($fichas as $keyf => $f) {
    //         $ficha = FichasNacimiento::where([['id',$f->id],['condic_id',1]])->first();
    //         if(($ficha)){
    //             $ficha->nacimi_id = $r->id;
    //             $ficha->save();
    //         }
    //         }
    //     }
    //     return "Se termino de registrar la fichas B que coinciden con el código del registro";
    // }
    // public function registrarFichasNacimientoOrdinariasC()
    // {
    //     $nacimientosOrdinarios= Nacimiento::where("condic",1)->get();
    //     $fichas=[];
    //     foreach ($nacimientosOrdinarios as $keyr => $r) {
    //         $fichas= FichasNacimiento::where([['nombre_sin_extension',$r->ano_nac.$r->nro_fol.'C'],['condic_id',1]])
    //         ->get();
    //         foreach ($fichas as $keyf => $f) {
    //         $ficha = FichasNacimiento::where([['id',$f->id],['condic_id',1]])->first();
    //         if(($ficha)){
    //             $ficha->nacimi_id = $r->id;
    //             $ficha->save();
    //         }
    //         }
    //     }
    //     return "Se termino de registrar la fichas C que coinciden con el código del registro";
    // }
    // public function registrarFichasNacimientoOrdinariasD()
    // {
    //     $nacimientosOrdinarios= Nacimiento::where("condic",1)->get();
    //     $fichas=[];
    //     foreach ($nacimientosOrdinarios as $keyr => $r) {
    //         $fichas= FichasNacimiento::where([['nombre_sin_extension',$r->ano_nac.$r->nro_fol.'D'],['condic_id',1]])
    //         ->get();
    //         foreach ($fichas as $keyf => $f) {
    //         $ficha = FichasNacimiento::where([['id',$f->id],['condic_id',1]])->first();
    //         if(($ficha)){
    //             $ficha->nacimi_id = $r->id;
    //             $ficha->save();
    //         }
    //         }
    //     }
    //     return "Se termino de registrar la fichas D que coinciden con el código del registro";
    // }

    // public function indexarFichasMatrimonioOrdinarias()
    // {
    //     $FichaOrdinariaNacimientoList = Storage::disk('fichas-ordinarias-matri')->allFiles();
    //     foreach ($FichaOrdinariaNacimientoList as $key => $fichaOrdinariaNacim) {
    //         $ficha = new FichasMatrimonio();
    //         $ficha->condic_id = 1;
    //         $ficha->nombre_completo = $fichaOrdinariaNacim;
    //         $ficha->nombre_sin_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_FILENAME);
    //         $ficha->nombre_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_EXTENSION);
    //         $ficha->ruta = '/fichas/ordinarias/matri/' . $fichaOrdinariaNacim;
    //         $ficha->estado = 1;
    //         $ficha->save();
    //     }

    //     return "Se termino de indexar todas las fichas";
    // }
    // public function indexarFichasMatrimonioExtraordinarias()
    // {
    //     $FichaOrdinariaNacimientoList = Storage::disk('fichas-extraordinarias-matri')->allFiles();
    //     foreach ($FichaOrdinariaNacimientoList as $key => $fichaOrdinariaNacim) {
    //         $ficha = new FichasMatrimonio();
    //         $ficha->condic_id = 2;
    //         $ficha->nombre_completo = $fichaOrdinariaNacim;
    //         $ficha->nombre_sin_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_FILENAME);
    //         $ficha->nombre_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_EXTENSION);
    //         $ficha->ruta = '/fichas/extraordiarias/matri/' . $fichaOrdinariaNacim;
    //         $ficha->estado = 1;
    //         $ficha->save();
    //     }

    //     return "Se termino de indexar todas las fichas";
    // }
    // public function indexarFichasDefuncionOrdinarias()
    // {
    //     $FichaOrdinariaNacimientoList = Storage::disk('fichas-ordinarias-defun')->allFiles();
    //     foreach ($FichaOrdinariaNacimientoList as $key => $fichaOrdinariaNacim) {
    //         $ficha = new FichasDefuncion();
    //         $ficha->condic_id = 1;
    //         $ficha->nombre_completo = $fichaOrdinariaNacim;
    //         $ficha->nombre_sin_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_FILENAME);
    //         $ficha->nombre_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_EXTENSION);
    //         $ficha->ruta = '/fichas/ordinarias/defun/' . $fichaOrdinariaNacim;
    //         $ficha->estado = 1;
    //         $ficha->save();
    //     }

    //     return "Se termino de indexar todas las fichas";
    // }
    // public function indexarFichasDefuncionExtraordinarias()
    // {
    //     $FichaOrdinariaNacimientoList = Storage::disk('fichas-extraordinarias-defun')->allFiles();
    //     foreach ($FichaOrdinariaNacimientoList as $key => $fichaOrdinariaNacim) {
    //         $ficha = new FichasDefuncion();
    //         $ficha->condic_id = 2;
    //         $ficha->nombre_completo = $fichaOrdinariaNacim;
    //         $ficha->nombre_sin_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_FILENAME);
    //         $ficha->nombre_extension = pathinfo($fichaOrdinariaNacim, PATHINFO_EXTENSION);
    //         $ficha->ruta = '/fichas/extraordiarias/defun/' . $fichaOrdinariaNacim;
    //         $ficha->estado = 1;
    //         $ficha->save();
    //     }

    //     return "Se termino de indexar todas las fichas";
    // }
}
