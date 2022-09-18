<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Defuncion;
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

class ControlDeMatrimoniosController extends Controller
{
    public function index(Request $request)
    {

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
            $adjunto = $this->buscarFicha($id,'matri');
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
                $nuevoMatrimonio = new Matrimonio();
                $nuevoMatrimonio->ano_cel = $request->ano_cel;
                $nuevoMatrimonio->ano_eje = $now->year;
                $nuevoMatrimonio->nro_lib = $request->nro_lib;
                $nuevoMatrimonio->nro_fol = $request->nro_fol;

                $nuevoMatrimonio->ape_pat_ma = $request->ape_pat_ma;
                $nuevoMatrimonio->ape_mat_ma = $request->ape_mat_ma;
                $nuevoMatrimonio->nom_mar = $request->nom_mar;
                $nuevoMatrimonio->ubigeo1 = $request->ubigeo1;
                $nuevoMatrimonio->ape_pat_es = $request->ape_pat_es;
                $nuevoMatrimonio->ape_mat_es = $request->ape_mat_es;
                $nuevoMatrimonio->nom_esp = $request->nom_esp;
                $nuevoMatrimonio->ubigeo2 = $request->ubigeo2;
                $nuevoMatrimonio->fch_cel = $request->fch_cel;
                $nuevoMatrimonio->fch_reg = $request->fch_reg;
                $nuevoMatrimonio->tipo = $request->tipo;
                $nuevoMatrimonio->usuario = Auth::user()->usuario; //$request->usuario;
                $nuevoMatrimonio->save();

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
                $nuevoCobro->tipo ='M';
                $nuevoCobro->fecha = $request->fecha_recibo;
                $nuevoCobro->ano = $request->ano;
                $nuevoCobro->libro = $request->libro;
                $nuevoCobro->folio = $request->folio;
                $nuevoCobro->estado ='P';
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

            $matrimonio->ape_pat_ma = $request->ape_pat_ma;
            $matrimonio->ape_mat_ma = $request->ape_mat_ma;
            $matrimonio->nom_mar = $request->nom_mar;
            $matrimonio->ubigeo1 = $request->ubigeo1;
            $matrimonio->ape_pat_es = $request->ape_pat_es;
            $matrimonio->ape_mat_es = $request->ape_mat_es;
            $matrimonio->nom_esp = $request->nom_esp;
            $matrimonio->ubigeo2 = $request->ubigeo2;
            $matrimonio->fch_cel = $request->fch_cel;
            $matrimonio->fch_reg = $request->fch_reg;
            $matrimonio->tipo = $request->tipo;
            $matrimonio->usuario = Auth::user()->usuario; //$request->usuario;
            $matrimonio->save();

            // inicia el guardado de adjuntos
            $newNameFile='';
            $archivoAdjuntoLength = $request->archivo_adjunto != null ? count($request->archivo_adjunto) : 0;
            if($archivoAdjuntoLength>0){
                foreach (($request->archivo_adjunto) as $key => $archivo) {
                    if ($archivo != null) {
                        // $file = $archivo->getClientOriginalName();
                        // $extension = pathinfo($file, PATHINFO_EXTENSION);
                        $newNameFile = $request->nombre_adjunto[$key];
                        Storage::disk('fichas-matri')->put($newNameFile, File::get($archivo));
        
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

    public function validarSiExisteRegistroDuplicado($ano_cel, $nro_lib, $nro_fol)
    {
        $CantidadRegistrosDeMatrimonio = Matrimonio::where(
            [
                ['ano_cel', $ano_cel],
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
}
