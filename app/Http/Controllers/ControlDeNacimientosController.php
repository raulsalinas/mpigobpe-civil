<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\Defuncion;
use App\Models\Matrimonio;
use App\Models\Nacimiento;
use App\Models\Recibo;
use App\Models\TipoRegistro;
use App\Models\Ubigeo;
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
            $adjunto = $this->buscarFicha($id,'nacim');
            $data->setAttribute('adjunto',$adjunto);
        }
        return response()->json($data, 200);
    }
    public function buscarFicha($id,$folder)
    {
        /*
        $carpeta : nacim, matri, defun
        */
        $variantes=['A','B','C','D','E'];
        $nombreBase = '';
        $archivoEncontrado=[];

        switch ($folder) {
            case 'nacim':
                $data= Nacimiento::find($id);
                $nombreBase = $data->ano_nac.$data->nro_fol;
                $archivoEncontrado=[
                    'folder'=>'nacim',
                    'año'=>$data->ano_nac,
                    'folio'=>$data->nro_fol,
                    'nombre_base'=>$nombreBase,
                ];
                break;
            case 'matri':
                $data= Matrimonio::find($id);
                $nombreBase = $data->ano_cel.$data->nro_fol;
                $archivoEncontrado=[
                    'folder'=>'nacim',
                    'año'=>$data->ano_cel,
                    'folio'=>$data->nro_fol,
                    'nombre_base'=>$nombreBase,
                ];
                break;
            case 'defun':
                $data= Defuncion::find($id);
                $nombreBase = $data->ano_des.$data->nro_fol;
                $archivoEncontrado=[
                    'folder'=>'nacim',
                    'año'=>$data->ano_des,
                    'folio'=>$data->nro_fol,
                    'nombre_base'=>$nombreBase,
                ];
                break;
            default:
                break;
        }
 
        // $fichas = Storage::disk('fichas-nacimiento')->allFiles();
        $existeArchivoNombreBase = intval(Storage::disk('fichas-'.$folder)->exists($nombreBase . '.tif'));

        $existeArchivoNombreA = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'A.TIF'));
        $existeArchivoNombreB = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'B.TIF'));
        $existeArchivoNombreC = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'C.TIF'));
        $existeArchivoNombreD = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'D.TIF'));
        $existeArchivoNombreE = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'E.TIF'));

        $archivoEncontrado['existe_archivo_nombre_base']=boolval($existeArchivoNombreBase);
        $archivoEncontrado['existe_archivo_nombre_a']=boolval($existeArchivoNombreA);
        $archivoEncontrado['existe_archivo_nombre_b']=boolval($existeArchivoNombreB);
        $archivoEncontrado['existe_archivo_nombre_c']=boolval($existeArchivoNombreC);
        $archivoEncontrado['existe_archivo_nombre_d']=boolval($existeArchivoNombreD);
        $archivoEncontrado['existe_archivo_nombre_e']=boolval($existeArchivoNombreE);
 
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
                $nuevoNacimiento->condic_nac = $request->condicionActa;
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
            $nacimiento->condic_nac = $request->condicionActa;
            $nacimiento->save();

            // inicia el guardado de adjuntos
            $newNameFile='';
            $archivoAdjuntoLength = $request->archivo_adjunto != null ? count($request->archivo_adjunto) : 0;
            if($archivoAdjuntoLength>0){
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
            $nacimiento->observacion = $request->observacion;
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


    public function visualizarAdjuntoNacimiento(Request $request)
    {
        return view('nacimientos.visualizar_adjunto_nacimiento', get_defined_vars());
    }
 
}
