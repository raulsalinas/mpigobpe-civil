<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\Cobro;
use App\Models\Defuncion;
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
            $data->setAttribute('adjunto', $this->obtenerAdjuntos($id));
        }
        return response()->json($data, 200);
    }

    public function obtenerAdjuntos($id)
    {
        $adjuntos = $this->buscarFicha($id, 'nacim');
        return $adjuntos;
    }

    public function obtenerAdjuntosLista($id)
    {
        $adjuntos = $this->buscarFicha($id, 'nacim');
        $files = [];
        if ($adjuntos['existe_archivo_nombre_base_tif'] == true) {
            $files[] = [

                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . '.tif',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_base_pdf'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . '.pdf',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_a_tif'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'A.tif',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_a_pdf'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'A.pdf',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_b_tif'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'B.pdf',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_b_pdf'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'B.tif',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_c_tif'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'C.tif',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_c_pdf'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'C.pdf',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_d_tif'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'D.tif',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_d_pdf'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'D.pdf',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_e_tif'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'E.tif',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        if ($adjuntos['existe_archivo_nombre_e_pdf'] == true) {
            $files[] = [
                'idRegistro' => $adjuntos['idRegistro'],
                'nameFile' => $adjuntos['nombre_base'] . 'E.pdf',
                'year' => $adjuntos['año'],
                'book' => $adjuntos['book'],
                'folio' => $adjuntos['folio'],
            ];
        }
        return $files;
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
                $nombreBase = $data->ano_nac . $data->nro_fol;
                $archivoEncontrado = [
                    'idRegistro' => $id,
                    'folder' => 'nacim',
                    'año' => $data->ano_nac,
                    'book' => $data->nro_lib,
                    'folio' => $data->nro_fol,
                    'nombre_base' => $nombreBase,
                ];
                break;
            case 'matri':
                $data = Matrimonio::find($id);
                $nombreBase = $data->ano_cel . $data->nro_fol;
                $archivoEncontrado = [
                    'idRegistro' => $id,
                    'folder' => 'nacim',
                    'año' => $data->ano_cel,
                    'book' => $data->nro_lib,
                    'folio' => $data->nro_fol,
                    'nombre_base' => $nombreBase,
                ];
                break;
            case 'defun':
                $data = Defuncion::find($id);
                $nombreBase = $data->ano_des . $data->nro_fol;
                $archivoEncontrado = [
                    'idRegistro' => $id,
                    'folder' => 'nacim',
                    'año' => $data->ano_des,
                    'book' => $data->nro_lib,
                    'folio' => $data->nro_fol,
                    'nombre_base' => $nombreBase,
                ];
                break;
            default:
                break;
        }

        // $fichas = Storage::disk('fichas-nacimiento')->allFiles();
        $existeArchivoNombreBaseTIF = intval(Storage::disk('fichas-' . $folder)->exists($nombreBase . '.tif'));
        $existeArchivoNombreBasePDF = intval(Storage::disk('fichas-' . $folder)->exists($nombreBase . '.pdf'));

        $existeArchivoNombreATIF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'A.TIF'));
        $existeArchivoNombreAPDF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'A.PDF'));
        $existeArchivoNombreBTIF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'B.TIF'));
        $existeArchivoNombreBPDF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'B.PDF'));
        $existeArchivoNombreCTIF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'C.TIF'));
        $existeArchivoNombreCPDF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'C.PDF'));
        $existeArchivoNombreDTIF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'D.TIF'));
        $existeArchivoNombreDPDF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'D.PDF'));
        $existeArchivoNombreETIF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'E.TIF'));
        $existeArchivoNombreEPDF = intval(Storage::disk('fichas')->exists($folder . '/' . $nombreBase . 'E.PDF'));

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
            $validar = $this->validarSiExisteRegistroDuplicado($request->ano_naci, $request->nro_lib, $request->nro_fol);

            if ($validar > 0) {
                $respuesta = 'duplicado';
                $alerta = 'warning';
                $mensaje = 'Duplicado, Se encontró un registro con el mismo documento';
                $error = "";
            } else {
                $now = Carbon::now();
                $nuevoNacimiento = new Nacimiento();
                $nuevoNacimiento->ano_nac = $request->ano_nac;
                $nuevoNacimiento->ano_eje = $now->year;
                $nuevoNacimiento->nro_lib = $request->nro_lib;
                $nuevoNacimiento->nro_fol = $request->nro_fol;
                $nuevoNacimiento->ape_pat_na = $request->ape_pat_na;
                $nuevoNacimiento->ape_mat_na = $request->ape_mat_na;
                $nuevoNacimiento->nom_nac = $request->nom_nac;
                $nuevoNacimiento->cen_asi = $request->cen_asi;
                $nuevoNacimiento->sex_nac = $request->sex_nac;
                $nuevoNacimiento->ubigeo = $request->ubigeo;
                $nuevoNacimiento->fch_nac = $request->fch_nac;
                $nuevoNacimiento->fch_ing = $request->fch_ing;
                $nuevoNacimiento->tipo = $request->tipo;
                $nuevoNacimiento->usuario = Auth::user()->usuario; //$request->usuario;
                $nuevoNacimiento->ape_pat_ma = $request->ape_pat_ma;
                $nuevoNacimiento->ape_mat_ma = $request->ape_mat_ma;
                $nuevoNacimiento->nom_mad = $request->nom_mad;
                $nuevoNacimiento->dir_mad = $request->dir_mad;
                $nuevoNacimiento->ape_pat_pa = $request->ape_pat_pa;
                $nuevoNacimiento->ape_mat_pa = $request->ape_mat_pa;
                $nuevoNacimiento->nom_pad = $request->nom_pad;
                $nuevoNacimiento->dir_pad = $request->dir_pad;
                $nuevoNacimiento->condic = $request->condicionActa;
                $nuevoNacimiento->save();

                // if ($request->aplicaRecibo == true) {
                //     $nuevorecibo = new Recibo();
                //     $nuevorecibo->fecibo = $request->nro_recibo;
                //     $nuevorecibo->fecha = $request->fecha_recibo;
                //     $nuevorecibo->tipo = $request->tipo_recibo;
                //     $nuevorecibo->monto = $request->importe_recibo;
                //     $nuevorecibo->nombre = $request->nombre_solicitante_recibo;
                //     $nuevorecibo->save();
                // }

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
            $nacimiento->ano_nac = $request->ano_nac;
            // $nacimiento->ano_eje = $request->ano_eje;
            $nacimiento->nro_lib = $request->nro_lib;
            $nacimiento->nro_fol = $request->nro_fol;
            $nacimiento->ape_pat_na = $request->ape_pat_na;
            $nacimiento->ape_mat_na = $request->ape_mat_na;
            $nacimiento->nom_nac = $request->nom_nac;
            $nacimiento->cen_asi = $request->cen_asi;
            $nacimiento->sex_nac = $request->sex_nac;
            $nacimiento->ubigeo = $request->ubigeo;
            $nacimiento->fch_nac = $request->fch_nac;
            $nacimiento->fch_ing = $request->fch_ing;
            $nacimiento->tipo = $request->tipo;
            $nacimiento->usuario = Auth::user()->usuario; //$request->usuario;
            $nacimiento->ape_pat_ma = $request->ape_pat_ma;
            $nacimiento->ape_mat_ma = $request->ape_mat_ma;
            $nacimiento->nom_mad = $request->nom_mad;
            $nacimiento->dir_mad = $request->dir_mad;
            $nacimiento->ape_pat_pa = $request->ape_pat_pa;
            $nacimiento->ape_mat_pa = $request->ape_mat_pa;
            $nacimiento->nom_pad = $request->nom_pad;
            $nacimiento->dir_pad = $request->dir_pad;
            $nacimiento->condic = $request->condicionActa;
            $nacimiento->save();

            // inicia el guardado de adjuntos
            $newNameFile = '';
            $archivoAdjuntoLength = $request->archivo_adjunto != null ? count($request->archivo_adjunto) : 0;
            if ($archivoAdjuntoLength > 0) {
                foreach (($request->archivo_adjunto) as $key => $archivo) {
                    if ($archivo != null) {
                        // $file = $archivo->getClientOriginalName();
                        // $extension = pathinfo($file, PATHINFO_EXTENSION);
                        $newNameFile = $request->nombre_adjunto[$key];
                        Storage::disk('fichas-nacim')->put($newNameFile, File::get($archivo));
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

    public function validarSiExisteRegistroDuplicado($ano_naci, $nro_lib, $nro_fol)
    {
        $CantidadRegistrosDeNacimientos = Nacimiento::where(
            [
                ['ano_naci', $ano_naci],
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

        $adjuntos = $this->obtenerAdjuntosLista($idRegistro);
        return view('nacimientos.visualizar_adjunto_nacimiento', get_defined_vars());
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

            $pathSource = Storage::disk('fichas-nacim')->getDriver()->getAdapter()->applyPathPrefix($nombreArchivo);
            $destinationPath = Storage::disk('fichas-nacim')->getDriver()->getAdapter()->applyPathPrefix('archivado/' . $nombreArchivo);

            // // make destination folder
            if (!File::exists(dirname($destinationPath))) {
                File::makeDirectory(dirname($destinationPath), null, true);
            }

            File::move($pathSource, $destinationPath);

            $existeArchivo = intval(Storage::disk('fichas')->exists('nacim/archivado/' . $nombreArchivo));

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
