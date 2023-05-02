<?php

namespace App\Http\Controllers;

use App\Helpers\AdjuntoHelper;
use App\Models\Cobro;
use App\Models\Defuncion;
use App\Models\FichasMatrimonio;
use App\Models\Matrimonio;
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

class ControlDeMatrimoniosController extends Controller
{
    public function index(Request $request)
    {
        $tipo =  $request->query('tipo');
        $usuarioList = (new ControlDeNacimientosController)->usuarioList();
        $ubigeoList = (new ControlDeNacimientosController)->ubigeoList();
        $usuario = Auth::user()->usuario;
        $tipoRegistroList = (new ControlDeNacimientosController)->tipoRegistroList();
        return view('matrimonios.control_de_matrimonios', get_defined_vars());
    }

    public function visualizar($id)
    {
        $data = $id;
        if ($id > 0) {
            $data = Matrimonio::find($id);
            $adjuntoHelper = new AdjuntoHelper();
            $data->setAttribute('adjuntos', $adjuntoHelper->obtenerAdjuntos($id, 'matrimonios'));
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
    public function buscarFicha($id, $folder)
    {
        /*
        $carpeta : nacim, matri, defun
        */
        $variantes = ['A', 'B', 'C', 'D', 'E'];
        $nombreBase = '';
        $archivoEncontrado = [];

        switch ($folder) {
            case 'nacim':
                $data = Nacimiento::find($id);
                $carpetaPadre = $this->getCarpetaPadreCondicion($data->condic);
                $nombreBase = $data->ano_nac . $data->nro_fol;
                $archivoEncontrado = [
                    'idRegistro' => $id,
                    'folder' => 'nacim',
                    'año' => $data->ano_nac,
                    'book' => $data->nro_lib,
                    'folio' => $data->nro_fol,
                    'nombre_base' => $nombreBase,
                    'condic' => $data->condic,
                ];
                break;
            case 'matri':
                $data = Matrimonio::find($id);
                $carpetaPadre = $this->getCarpetaPadreCondicion($data->condic);
                $nombreBase = $data->ano_cel . $data->nro_fol;
                $archivoEncontrado = [
                    'idRegistro' => $id,
                    'folder' => 'matri',
                    'año' => $data->ano_cel,
                    'book' => $data->nro_lib,
                    'folio' => $data->nro_fol,
                    'nombre_base' => $nombreBase,
                    'condic' => $data->condic,
                ];
                break;
            case 'defun':
                $data = Defuncion::find($id);
                $carpetaPadre = $this->getCarpetaPadreCondicion($data->condic);
                $nombreBase = $data->ano_des . $data->nro_fol;
                $archivoEncontrado = [
                    'idRegistro' => $id,
                    'folder' => 'defun',
                    'año' => $data->ano_des,
                    'book' => $data->nro_lib,
                    'folio' => $data->nro_fol,
                    'nombre_base' => $nombreBase,
                    'condic' => $data->condic,
                ];
                break;
            default:
                break;
        }
        $ruta = 'fichas-' . $carpetaPadre . '-' . $folder;


        // $fichas = Storage::disk('fichas-nacimiento')->allFiles();
        $existeArchivoNombreBaseTIF = intval(Storage::disk($ruta)->exists($nombreBase . '.tif'));
        $existeArchivoNombreBasePDF = intval(Storage::disk($ruta)->exists($nombreBase . '.pdf'));

        $existeArchivoNombreATIF = intval(Storage::disk($ruta)->exists($nombreBase . 'A.TIF'));
        $existeArchivoNombreAPDF = intval(Storage::disk($ruta)->exists($nombreBase . 'A.PDF'));
        $existeArchivoNombreBTIF = intval(Storage::disk($ruta)->exists($nombreBase . 'B.TIF'));
        $existeArchivoNombreBPDF = intval(Storage::disk($ruta)->exists($nombreBase . 'B.PDF'));
        $existeArchivoNombreCTIF = intval(Storage::disk($ruta)->exists($nombreBase . 'C.TIF'));
        $existeArchivoNombreCPDF = intval(Storage::disk($ruta)->exists($nombreBase . 'C.PDF'));
        $existeArchivoNombreDTIF = intval(Storage::disk($ruta)->exists($nombreBase . 'D.TIF'));
        $existeArchivoNombreDPDF = intval(Storage::disk($ruta)->exists($nombreBase . 'D.PDF'));
        $existeArchivoNombreETIF = intval(Storage::disk($ruta)->exists($nombreBase . 'E.TIF'));
        $existeArchivoNombreEPDF = intval(Storage::disk($ruta)->exists($nombreBase . 'E.PDF'));

        $archivoEncontrado['existe_archivo_nombre_base_tif'] = boolval($existeArchivoNombreBaseTIF);
        $archivoEncontrado['existe_archivo_nombre_base_pdf'] = boolval($existeArchivoNombreBasePDF);
        $archivoEncontrado['existe_archivo_nombre_a_tif'] = boolval($existeArchivoNombreATIF);
        $archivoEncontrado['existe_archivo_nombre_a_pdf'] = boolval($existeArchivoNombreAPDF);
        $archivoEncontrado['existe_archivo_nombre_b_tif'] = boolval($existeArchivoNombreBTIF);
        $archivoEncontrado['existe_archivo_nombre_b_pdf'] = boolval($existeArchivoNombreBPDF);
        $archivoEncontrado['existe_archivo_nombre_c_tif'] = boolval($existeArchivoNombreCTIF);
        $archivoEncontrado['existe_archivo_nombre_c_pdf'] = boolval($existeArchivoNombreCPDF);
        $archivoEncontrado['existe_archivo_nombre_d_tif'] = boolval($existeArchivoNombreDTIF);
        $archivoEncontrado['existe_archivo_nombre_d_pdf'] = boolval($existeArchivoNombreDPDF);
        $archivoEncontrado['existe_archivo_nombre_e_tif'] = boolval($existeArchivoNombreETIF);
        $archivoEncontrado['existe_archivo_nombre_e_pdf'] = boolval($existeArchivoNombreEPDF);
        return $archivoEncontrado;
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
                $nuevoMatrimonio = new Matrimonio();
                $nuevoMatrimonio->ano_cel = Carbon::createFromFormat('Y-m-d', $request->fch_cel)->format('Y');
                $nuevoMatrimonio->ano_eje = $request->ano_eje;
                $nuevoMatrimonio->nro_lib = $request->nro_lib;
                $nuevoMatrimonio->nro_fol = $request->nro_fol;

                $nuevoMatrimonio->ape_mar = Str::upper($request->ape_mar);
                $nuevoMatrimonio->nom_mar = Str::upper($request->nom_mar);
                $nuevoMatrimonio->ubigeo1 = Str::upper($request->ubigeo1);
                $nuevoMatrimonio->ape_esp = Str::upper($request->ape_esp);
                $nuevoMatrimonio->nom_esp = Str::upper($request->nom_esp);
                $nuevoMatrimonio->ubigeo2 = $request->ubigeo2;
                $nuevoMatrimonio->fch_cel = $request->fch_cel;
                $nuevoMatrimonio->fch_reg = $request->fch_reg;
                $nuevoMatrimonio->tipo = $request->tipo;
                $nuevoMatrimonio->usuario = Auth::user()->usuario; //$request->usuario;
                $nuevoMatrimonio->condic = $request->condicionActa;
                $nuevoMatrimonio->save();


                // inicia el guardado de adjuntos

                $carpetaPadre = $this->getCarpetaPadreCondicion($request->condicionActa);
                $ruta = 'fichas-' . $carpetaPadre . '-matri';
                $nombreCompletoArchivo = '';
                $archivoAdjuntoLength = $request->archivo_list != null ? count($request->archivo_list) : 0;
                $rutaDisco = config('filesystems.disks.' . $ruta)['root'];
                $iniciarRuta= strpos($rutaDisco, 'fichas');
                $newRuta = substr($rutaDisco,$iniciarRuta);
                $rutaFicha = '/' . $newRuta . '/';

                if ($archivoAdjuntoLength > 0) {
                    foreach (($request->archivo_list) as $key => $archivo) {
                        if ($archivo != null && $request->accion_list[$key] == 'GUARDAR') {
                            $nombreCompletoArchivo = $request->nombre_completo_list[$key];
                            Storage::disk($ruta)->put($nombreCompletoArchivo, File::get($archivo));


                            $nuevoArchivo = new FichasMatrimonio();
                            $nuevoArchivo->condic_id = $nuevoMatrimonio->condic;
                            $nuevoArchivo->nombre_completo = $request->nombre_completo_list[$key];
                            $nuevoArchivo->nombre_sin_extension = $request->nombre_sin_extension_list[$key];
                            $nuevoArchivo->ruta = $rutaFicha . $request->nombre_completo_list[$key];
                            $nuevoArchivo->nombre_extension = $request->nombre_extension_list[$key];
                            $nuevoArchivo->matrim_id = $nuevoMatrimonio->id;
                            $nuevoArchivo->created_at = Carbon::now();
                            $nuevoArchivo->save();
                        }
                    }
                }
                // terminar el guardado de adjuntos


                $respuesta = 'ok';
                $alerta = 'success';
                $mensaje = 'Matrimonio registrado con éxito';
                $error = '';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $nuevoMatrimonio->id ?? '', 'error' => $error), 200);
    }

    public function guardarCobro(Request $request)
    {
        try {

            if ($request->aplicaRecibo == true) {
                $nuevoCobro = new Cobro();
                $nuevoCobro->recibo = $request->nro_recibo;
                $nuevoCobro->tipo = 'M';
                $nuevoCobro->fecha = $request->fecha_recibo;
                $nuevoCobro->ano = $request->ano;
                $nuevoCobro->libro = $request->libro;
                $nuevoCobro->folio = $request->folio;
                $nuevoCobro->estado = 'P';
                $nuevoCobro->monto = $request->importe_recibo;
                $nuevoCobro->solicitant = $request->nombre_solicitante_recibo;
                $nuevoCobro->condic = isset($request->condic)?$request->condic:null;
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
                $nuevorecibo->matrim_id = $request->matrim_id;
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

    public function actualizar(Request $request)
    {
        try {

            $matrimonio = Matrimonio::find($request->id);

            $matrimonio->ano_cel = Carbon::createFromFormat('Y-m-d', $request->fch_cel)->format('Y');
            $matrimonio->ape_mar = Str::upper($request->ape_mar);
            $matrimonio->nom_mar = Str::upper($request->nom_mar);
            $matrimonio->ubigeo1 = Str::upper($request->ubigeo1);
            $matrimonio->ape_esp = Str::upper($request->ape_esp);
            $matrimonio->nom_esp = Str::upper($request->nom_esp);
            $matrimonio->ubigeo2 = $request->ubigeo2;
            $matrimonio->fch_cel = $request->fch_cel;
            $matrimonio->fch_reg = $request->fch_reg;
            $matrimonio->tipo = $request->tipo;
            $matrimonio->usuario = Auth::user()->usuario; //$request->usuario;
            $matrimonio->condic = $request->condicionActa;
            $matrimonio->save();


            // inicia el guardado de adjuntos

            $carpetaPadre = $this->getCarpetaPadreCondicion($request->condicionActa);
            $ruta = 'fichas-' . $carpetaPadre . '-matri';
            $nombreCompletoArchivo = '';
            $archivoAdjuntoLength = $request->archivo_list != null ? count($request->archivo_list) : 0;
            $rutaDisco = config('filesystems.disks.' . $ruta)['root'];
            $iniciarRuta= strpos($rutaDisco, 'fichas');
            $newRuta = substr($rutaDisco,$iniciarRuta);
            $rutaFicha = '/' . $newRuta . '/';

            if ($archivoAdjuntoLength > 0) {
                foreach (($request->archivo_list) as $key => $archivo) {
                    if ($archivo != null && $request->accion_list[$key] == 'GUARDAR') {
                        $nombreCompletoArchivo = $request->nombre_completo_list[$key];
                        Storage::disk($ruta)->put($nombreCompletoArchivo, File::get($archivo));


                        $nuevoArchivo = new FichasMatrimonio();
                        $nuevoArchivo->condic_id = $matrimonio->condic;
                        $nuevoArchivo->nombre_completo = $request->nombre_completo_list[$key];
                        $nuevoArchivo->nombre_sin_extension = $request->nombre_sin_extension_list[$key];
                        $nuevoArchivo->ruta = $rutaFicha . $request->nombre_completo_list[$key];
                        $nuevoArchivo->nombre_extension = $request->nombre_extension_list[$key];
                        $nuevoArchivo->matrim_id = $matrimonio->id;
                        $nuevoArchivo->created_at = Carbon::now();
                        $nuevoArchivo->save();
                    }
                }
            }
            // terminar el guardado de adjuntos

            $respuesta = 'ok';
            $alerta = 'success';
            $mensaje = 'Se ha editado un registro de matrimonio';
            $error = '';
            // DB::commit();
        } catch (Exception $ex) {
            // DB::rollBack();

            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $matrimonio->id ?? '', 'error' => $error), 200);
    }

    public function validarSiExisteRegistroDuplicado($ano_eje, $nro_lib, $nro_fol)
    {
        $CantidadRegistrosDeMatrimonio = Matrimonio::where(
            [
                ['ano_cel', $ano_eje],
                ['nro_lib', $nro_lib],
                ['nro_fol', $nro_fol]
            ]
        )->count();
        return $CantidadRegistrosDeMatrimonio;
    }

    public function observar(Request $request)
    {
        try {

            $matrimonio = Matrimonio::find($request->id);
            $matrimonio->observa = $request->observa;
            $matrimonio->save();
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

    public function recuperar(Request $request)
    {
        try {

            $matrimonio = Matrimonio::withTrashed()->find($request->id);
            $matrimonio->deleted_at = null;
            $matrimonio->save();
            $respuesta = 'ok';
            $alerta = 'success';
            if ($request->id > 0) {
                $mensaje = 'Se ha recuperado el registro';
            } else {
                $mensaje = 'Hubo un problema, no se pudo recuperar el registro';
            }
            $error = '';
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al recuperar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }
    
    public function eliminar(Request $request)
    {
        try {

            $matrimonio = Matrimonio::find($request->id);
            $matrimonio->observa = $request->observa;
            $matrimonio->save();
            $matrimonio->delete();
            $respuesta = 'ok';
            $alerta = 'success';
            if ($request->id > 0) {
                $mensaje = 'Se ha eliminado el registro';
            } else {
                $mensaje = 'Hubo un problema, no se pudo eliminar el registro';
            }
            $error = '';
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al eliminar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }

    public function visualizarAdjuntoMatrimonio(Request $request)
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
            $ruta = 'fichas-' . $carpetaPadre . '-matri';
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
