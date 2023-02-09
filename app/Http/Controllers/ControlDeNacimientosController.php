<?php

namespace App\Http\Controllers;

use App\Helpers\AdjuntoHelper;
use App\Models\CentroAsistencial;
use App\Models\Cobro;
use App\Models\Defuncion;
use App\Models\FichasNacimiento;
use App\Models\Matrimonio;
use App\Models\Nacimiento;
use App\Models\Recibo;
use App\Models\TipoRegistro;
use App\Models\Ubigeo;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ControlDeNacimientosController extends Controller
{
    public function index(Request $request)
    {
        $tipo =  $request->query('tipo');
        $controlAsistencialList = $this->controlAsistencialList();
        $ubigeoList = $this->ubigeoList();
        $tipoRegistroList = $this->tipoRegistroList();
        $usuario = Auth::user()->usuario;

        return view('nacimientos.control_de_nacimientos', get_defined_vars());
    }

    public function visualizar($id)
    {
        $data = $id;
        if ($id > 0) {
            $data = Nacimiento::find($id);
            $adjuntoHelper = new AdjuntoHelper();
            $data->setAttribute('adjuntos', $adjuntoHelper->obtenerAdjuntos($id, 'nacimientos'));
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
                $nuevoNacimiento = new Nacimiento();
                $nuevoNacimiento->ano_eje = $request->ano_eje;
                $nuevoNacimiento->nro_lib = $request->nro_lib;
                $nuevoNacimiento->ano_nac = Carbon::createFromFormat('Y-m-d', $request->fch_nac)->format('Y');
                $nuevoNacimiento->nro_fol = $request->nro_fol;

                $nuevoNacimiento->ape_pat_nac = Str::upper($request->ape_pat_nac);
                $nuevoNacimiento->ape_mat_nac = Str::upper($request->ape_mat_nac);
                $nuevoNacimiento->nom_nac = Str::upper($request->nom_nac);

                $nuevoNacimiento->cen_asi = $request->cen_asi;
                $nuevoNacimiento->sex_nac = $request->sex_nac;
                $nuevoNacimiento->ubigeo = $request->ubigeo;
                $nuevoNacimiento->fch_nac = $request->fch_nac;
                $nuevoNacimiento->fch_ing = $request->fch_ing;
                $nuevoNacimiento->tipo = $request->tipo;
                $nuevoNacimiento->usuario = Auth::user()->usuario; //$request->usuario;

                $nuevoNacimiento->ape_mad = Str::upper($request->ape_mad);
                $nuevoNacimiento->nom_mad = Str::upper($request->nom_mad);
                $nuevoNacimiento->dir_mad = Str::upper($request->dir_mad);

                $nuevoNacimiento->ape_pad = Str::upper($request->ape_pad);
                $nuevoNacimiento->nom_pad = Str::upper($request->nom_pad);
                $nuevoNacimiento->dir_pad = Str::upper($request->dir_pad);

                $nuevoNacimiento->observa = Str::upper($request->observa);

                $nuevoNacimiento->condic = $request->condicionActa;
                $nuevoNacimiento->save();


                // inicia el guardado de adjuntos

                $carpetaPadre = $this->getCarpetaPadreCondicion($request->condicionActa);
                $ruta = 'fichas-' . $carpetaPadre . '-nacim';
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


                            $nuevoArchivo = new FichasNacimiento();
                            $nuevoArchivo->condic_id = $nuevoNacimiento->condic;
                            $nuevoArchivo->nombre_completo = $request->nombre_completo_list[$key];
                            $nuevoArchivo->nombre_sin_extension = $request->nombre_sin_extension_list[$key];
                            $nuevoArchivo->ruta = $rutaFicha . $request->nombre_completo_list[$key];
                            $nuevoArchivo->nombre_extension = $request->nombre_extension_list[$key];
                            $nuevoArchivo->nacimi_id = $nuevoNacimiento->id;
                            $nuevoArchivo->created_at = Carbon::now();
                            $nuevoArchivo->save();
                        }
                    }
                }
                // terminar el guardado de adjuntos

                $respuesta = 'ok';
                $alerta = 'success';
                $mensaje = 'Nacimiento registrado con éxito';
                $error = '';
            }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $nuevoNacimiento->id ?? '', 'error' => $error), 200);
    }

    public function ruta(Request $request)
    {
        $ruta = 'fichas-' . 'ordinarias' . '-nacim';
        $i = 0;
        $rutaFicha = config('filesystems.disks.' . $ruta)['root'];
        $array = explode("\\", $rutaFicha);
        foreach ($array as $key => $string) {
            if (strpos($string, 'fichas') === 0) {
                $i = $key;
            }
        }
        return $array[$i];
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
                $nuevoCobro->tipo = 'N';
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

    public function actualizar(Request $request)
    {
        try {

            $nacimiento = Nacimiento::find($request->id);

            $nacimiento->ano_nac =  Carbon::createFromFormat('Y-m-d', $request->fch_nac)->format('Y');

            $nacimiento->ape_pat_nac = $request->ape_pat_nac;
            $nacimiento->ape_mat_nac = $request->ape_mat_nac;
            $nacimiento->nom_nac = $request->nom_nac;

            $nacimiento->cen_asi = $request->cen_asi;
            $nacimiento->sex_nac = $request->sex_nac;
            $nacimiento->ubigeo = $request->ubigeo;
            $nacimiento->fch_nac = $request->fch_nac;
            $nacimiento->fch_ing = $request->fch_ing;
            $nacimiento->tipo = $request->tipo;
            $nacimiento->usuario = Auth::user()->usuario; //$request->usuario;

            $nacimiento->ape_mad = $request->ape_mad;
            $nacimiento->nom_mad = $request->nom_mad;
            $nacimiento->dir_mad = $request->dir_mad;

            $nacimiento->ape_pad = $request->ape_pad;
            $nacimiento->nom_pad = $request->nom_pad;
            $nacimiento->dir_pad = $request->dir_pad;

            $nacimiento->observa = $request->observa;

            $nacimiento->condic = $request->condicionActa;
            $nacimiento->save();


            // inicia el guardado de adjuntos

            $carpetaPadre = $this->getCarpetaPadreCondicion($request->condicionActa);
            $ruta = 'fichas-' . $carpetaPadre . '-nacim';
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


                        $nuevoArchivo = new FichasNacimiento();
                        $nuevoArchivo->condic_id = $nacimiento->condic;
                        $nuevoArchivo->nombre_completo = $request->nombre_completo_list[$key];
                        $nuevoArchivo->nombre_sin_extension = $request->nombre_sin_extension_list[$key];
                        $nuevoArchivo->ruta = $rutaFicha . $request->nombre_completo_list[$key];
                        $nuevoArchivo->nombre_extension = $request->nombre_extension_list[$key];
                        $nuevoArchivo->nacimi_id = $nacimiento->id;
                        $nuevoArchivo->created_at = Carbon::now();
                        $nuevoArchivo->save();
                    }
                }
            }
            // terminar el guardado de adjuntos

            $respuesta = 'ok';
            $alerta = 'success';
            $mensaje = 'Se ha editado un registro de nacimiento';
            $error = '';
            // DB::commit();
        } catch (Exception $ex) {
            // DB::rollBack();

            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al registrar. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'id' => $nacimiento->id ?? '', 'error' => $error), 200);
    }

    public function validarSiExisteRegistroDuplicado($ano_eje, $nro_lib, $nro_fol)
    {
        $CantidadRegistrosDeNacimientos = Nacimiento::where(
            [
                ['ano_eje', $ano_eje],
                ['nro_lib', $nro_lib],
                ['nro_fol', $nro_fol]
            ]
        )->count();
        return $CantidadRegistrosDeNacimientos;
    }

    public function observar(Request $request)
    {
        try {

            $nacimiento = Nacimiento::find($request->id);
            $nacimiento->observa = $request->observa;
            $nacimiento->save();
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

    public function controlAsistencialList()
    {
        $data = CentroAsistencial::where('codigo', '!=', null)->get();
        return $data;
    }
    public function ubigeoList()
    {
        $data = Ubigeo::where('codigo', '!=', null)->get();
        return $data;
    }
    public function tipoRegistroList()
    {
        $data = TipoRegistro::where('codigo', '!=', null)->get();
        return $data;
    }
    public function usuarioList()
    {
        $data = User::where('usuario', '!=', null)->get();
        return $data;
    }


    public function visualizarAdjuntoNacimiento(Request $request)
    {
        $idRegistro =  $request->query('idregistro');

        // $adjuntoHelper = new AdjuntoHelper();
        // $adjuntos= $adjuntoHelper->obtenerAdjuntos($idRegistro,'nacimientos');

        return view('adjuntos.visualizar_adjuntos', get_defined_vars());
    }
}
