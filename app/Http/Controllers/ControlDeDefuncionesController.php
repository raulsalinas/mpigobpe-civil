<?php

namespace App\Http\Controllers;

use App\Helpers\AdjuntoHelper;
use App\Models\Cobro;
use App\Models\Defuncion;
use App\Models\FichasDefuncion;
use App\Models\Lugar;
use App\Models\Matrimonio;
use App\Models\MotivoDefuncion;
use App\Models\Nacimiento;
use App\Models\Recibo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ControlDeDefuncionesController extends Controller
{
    public function index(Request $request)
    {
        $tipo =  $request->query('tipo');
        $usuarioList = (new ControlDeNacimientosController)->usuarioList();
        $ubigeoList = (new ControlDeNacimientosController)->ubigeoList();
        $usuario = Auth::user()->usuario;
        $tipoRegistroList = (new ControlDeNacimientosController)->tipoRegistroList();
        $lugarList = $this->lugarList();
        $motivoDecesoList = $this->motivoDecesoList();

        return view('defunciones.control_de_defunciones', get_defined_vars());
    }
    public function visualizar($id)
    {
        $data = $id;
        if ($id > 0) {
            $data = Defuncion::find($id);
            $adjuntoHelper = new AdjuntoHelper();
            $data->setAttribute('adjuntos', $adjuntoHelper->obtenerAdjuntos($id, 'defunciones'));
        }
        return response()->json($data, 200);
    }

    public function getCarpetaPadreCondicion($id)
    {
        switch (intval($id)) {
            case 1:

                return 'ordinarias';
                break;

            case 2:
                return 'extraordinarias';
                break;

            case 3:
                return 'especiales';
                break;

            default:
                return 'ordinarias';
                break;
        }
    }

    public function guardar(Request $request)
    {
        try {
            $validar = $this->validarSiExisteRegistroDuplicado($request->ano_eje, $request->nro_lib, $request->nro_fol);

            if ($validar > 0) {
                $respuesta = 'duplicado';
                $alerta = 'warning';
                $mensaje = 'Duplicado, Se encontró un registro con el mismo documento';
                $error = "";
            } else {
                $now = Carbon::now();
                $nuevaDefuncion = new Defuncion();
                $nuevaDefuncion->ano_des = Carbon::createFromFormat('Y-m-d', $request->fch_des)->format('Y');
                $nuevaDefuncion->ano_eje = $request->ano_eje;
                $nuevaDefuncion->nro_lib = $request->nro_lib;
                $nuevaDefuncion->nro_fol = $request->nro_fol;

                $nuevaDefuncion->ape_des = Str::upper($request->ape_des);
                $nuevaDefuncion->nom_des = Str::upper($request->nom_des);
                $nuevaDefuncion->dni = $request->dni;
                $nuevaDefuncion->sexo = $request->sexo;
                $nuevaDefuncion->lugar = $request->lugar;
                $nuevaDefuncion->ubigeo = $request->ubigeo;
                $nuevaDefuncion->cod_mot = $request->cod_mot;
                $nuevaDefuncion->fch_des = $request->fch_des;
                $nuevaDefuncion->fch_reg = $request->fch_reg;
                $nuevaDefuncion->tipo = $request->tipo;
                $nuevaDefuncion->usuario = Auth::user()->usuario; //$request->usuario;
                $nuevaDefuncion->condic = $request->condicionActa;

                $nuevaDefuncion->save();

                // inicia el guardado de adjuntos

                $carpetaPadre = $this->getCarpetaPadreCondicion($request->condicionActa);
                $ruta = 'fichas-' . $carpetaPadre . '-defun';
                $nombreCompletoArchivo = '';
                $archivoAdjuntoLength = $request->archivo_list != null ? count($request->archivo_list) : 0;
                $rutaDisco = config('filesystems.disks.' . $ruta)['root'];
                $array = explode("\\", $rutaDisco);
                $i = 0;
                foreach ($array as $key => $string) {
                    if (strpos($string, 'fichas') === 0) {
                        $i = $key;
                    }
                }
                $rutaFicha = '/' . $array[$i] . '/';

                if ($archivoAdjuntoLength > 0) {
                    foreach (($request->archivo_list) as $key => $archivo) {
                        if ($archivo != null && $request->accion_list[$key] == 'GUARDAR') {
                            $nombreCompletoArchivo = $request->nombre_completo_list[$key];
                            Storage::disk($ruta)->put($nombreCompletoArchivo, File::get($archivo));


                            $nuevoArchivo = new FichasDefuncion();
                            $nuevoArchivo->condic_id = $nuevaDefuncion->condic;
                            $nuevoArchivo->nombre_completo = $request->nombre_completo_list[$key];
                            $nuevoArchivo->nombre_sin_extension = $request->nombre_sin_extension_list[$key];
                            $nuevoArchivo->ruta = $rutaFicha . $request->nombre_completo_list[$key];
                            $nuevoArchivo->nombre_extension = $request->nombre_extension_list[$key];
                            $nuevoArchivo->nacimi_id = $nuevaDefuncion->id;
                            $nuevoArchivo->created_at = Carbon::now();
                            $nuevoArchivo->save();
                        }
                    }
                }
                // terminar el guardado de adjuntos

                $respuesta = 'ok';
                $alerta = 'success';
                $mensaje = 'Deceso registrado con éxito';
                $error = '';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $nuevaDefuncion->id ?? '', 'error' => $error), 200);
    }

    public function guardarRecibo(Request $request)
    {
        try {

            if ($request->aplicaRecibo == true) {
                $nuevorecibo = new Recibo();
                $nuevorecibo->fecibo = $request->nro_recibo;
                $nuevorecibo->fecha = $request->fecha_recibo;
                $nuevorecibo->tipo = $request->tipo_recibo;
                $nuevorecibo->monto = $request->importe_recibo;
                $nuevorecibo->nombre = $request->nombre_solicitante_recibo;
                $nuevorecibo->nacimi_id = $request->nacimi_id;
                $nuevorecibo->save();
            }

            $respuesta = 'ok';
            $alerta = 'success';
            $mensaje = 'Recibo registrado con éxito';
            $error = '';
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $nuevorecibo->id ?? '', 'error' => $error), 200);
    }

    public function guardarCobro(Request $request)
    {
        try {

            if ($request->aplicaRecibo == true) {
                $nuevoCobro = new Cobro();
                $nuevoCobro->recibo = $request->nro_recibo;
                $nuevoCobro->tipo = 'D';
                $nuevoCobro->fecha = $request->fecha_recibo;
                $nuevoCobro->ano = $request->ano;
                $nuevoCobro->libro = $request->libro;
                $nuevoCobro->folio = $request->folio;
                $nuevoCobro->estado = 'P';
                $nuevoCobro->monto = $request->importe_recibo;
                $nuevoCobro->solicitant = $request->nombre_solicitante_recibo;
                $nuevoCobro->save();
            }

            $respuesta = 'ok';
            $alerta = 'success';
            $mensaje = 'Cobro registrado con éxito';
            $error = '';
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $nuevoCobro->id ?? '', 'error' => $error), 200);
    }

    public function actualizar(Request $request)
    {
        try {

            $defuncion = Defuncion::find($request->id);

            $defuncion->ape_des = Str::upper($request->ape_des);
            $defuncion->nom_des = Str::upper($request->nom_des);
            $defuncion->dni = $request->dni;
            $defuncion->sexo = $request->sexo;
            $defuncion->lugar = $request->lugar;
            $defuncion->ubigeo = $request->ubigeo;
            $defuncion->cod_mot = $request->cod_mot;
            $defuncion->fch_des = $request->fch_des;
            $defuncion->fch_reg = $request->fch_reg;
            $defuncion->tipo = $request->tipo;
            $defuncion->condic = $request->condicionActa;
            $defuncion->save();


            // inicia el guardado de adjuntos

            $carpetaPadre = $this->getCarpetaPadreCondicion($request->condicionActa);
            $ruta = 'fichas-' . $carpetaPadre . '-defun';
            $nombreCompletoArchivo = '';
            $archivoAdjuntoLength = $request->archivo_list != null ? count($request->archivo_list) : 0;
            $rutaDisco = config('filesystems.disks.' . $ruta)['root'];
            $array = explode("\\", $rutaDisco);
            $i = 0;
            foreach ($array as $key => $string) {
                if (strpos($string, 'fichas') === 0) {
                    $i = $key;
                }
            }
            $rutaFicha = '/' . $array[$i] . '/';

            if ($archivoAdjuntoLength > 0) {
                foreach (($request->archivo_list) as $key => $archivo) {
                    if ($archivo != null && $request->accion_list[$key] == 'GUARDAR') {
                        $nombreCompletoArchivo = $request->nombre_completo_list[$key];
                        Storage::disk($ruta)->put($nombreCompletoArchivo, File::get($archivo));


                        $nuevoArchivo = new FichasDefuncion();
                        $nuevoArchivo->condic_id = $defuncion->condic;
                        $nuevoArchivo->nombre_completo = $request->nombre_completo_list[$key];
                        $nuevoArchivo->nombre_sin_extension = $request->nombre_sin_extension_list[$key];
                        $nuevoArchivo->ruta = $rutaFicha . $request->nombre_completo_list[$key];
                        $nuevoArchivo->nombre_extension = $request->nombre_extension_list[$key];
                        $nuevoArchivo->nacimi_id = $defuncion->id;
                        $nuevoArchivo->created_at = Carbon::now();
                        $nuevoArchivo->save();
                    }
                }
            }
            // terminar el guardado de adjuntos

            $respuesta = 'ok';
            $alerta = 'success';
            $mensaje = 'Se ha editado un registro de defunción';
            $error = '';
            // DB::commit();
        } catch (Exception $ex) {
            // DB::rollBack();

            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $defuncion->id ?? '', 'error' => $error), 200);
    }

    public function validarSiExisteRegistroDuplicado($ano_eje, $nro_lib, $nro_fol)
    {
        $CantidadRegistrosDeDefuncion = Defuncion::where(
            [
                ['ano_des', $ano_eje],
                ['nro_lib', $nro_lib],
                ['nro_fol', $nro_fol]
            ]
        )->count();
        return $CantidadRegistrosDeDefuncion;
    }

    public function observar(Request $request)
    {
        try {

            $defuncion = Defuncion::find($request->id);
            $defuncion->observa = $request->observa;
            $defuncion->save();
            $respuesta = 'ok';
            $alerta = 'success';
            if ($request->id > 0) {
                $mensaje = 'Se ha observado el registro';
            } else {
                $mensaje = 'Hubo un problema, no se pudo registrar la observación del registro';
            }
            $error = '';
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }

    public function lugarList()
    {
        $data = Lugar::where('codigo', '!=', null)->get();
        return $data;
    }
    public function motivoDecesoList()
    {
        $data = MotivoDefuncion::where('codigo', '!=', null)->get();
        return $data;
    }


    public function visualizarAdjuntoDefuncion(Request $request)
    {
        $idRegistro =  $request->query('idregistro');

        return view('adjuntos.visualizar_adjuntos', get_defined_vars());
    }

    public function archivarAdjunto(Request $request)
    {
        try {
            $respuesta = '';
            $alerta = '';
            $mensaje = '';
            $error = '';

            // $idRegistro =  $request->idregistro;
            $nombreArchivo =  $request->nombreArchivo;
            $data = Matrimonio::find($request->idRegistro);
            $carpetaPadre = $this->getCarpetaPadreCondicion($data->condic);
            $ruta = 'fichas-' . $carpetaPadre . '-defun';
            $pathSource = Storage::disk($ruta)->getDriver()->getAdapter()->applyPathPrefix($nombreArchivo);
            $destinationPath = Storage::disk($ruta)->getDriver()->getAdapter()->applyPathPrefix('archivado/' . $nombreArchivo);

            // // make destination folder
            if (!File::exists(dirname($destinationPath))) {
                File::makeDirectory(dirname($destinationPath), null, true);
            }

            File::move($pathSource, $destinationPath);

            $existeArchivo = intval(Storage::disk($ruta)->exists('archivado/' . $nombreArchivo));

            if ($existeArchivo == true) {
                $respuesta = 'ok';
                $alerta = 'success';
                $mensaje = 'El archivo adjunto fue archivado';
            } else {

                $alerta = 'warning';
                $mensaje = 'success';
                $mensaje = 'Hubo un problema al intentar archivar el archivo';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al intentar archivar el archivo. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }
}
