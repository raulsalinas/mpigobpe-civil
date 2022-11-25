<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Defuncion;
use App\Models\Lugar;
use App\Models\Matrimonio;
use App\Models\MotivoDefuncion;
use App\Models\Nacimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            $data->setAttribute('adjunto',$this->obtenerAdjuntos($id));
        }
        return response()->json($data, 200);
    }

    public function obtenerAdjuntos($id){
        $adjuntos = $this->buscarFicha($id,'defun');
        return $adjuntos;
    }

    public function obtenerAdjuntosLista($id){
        $adjuntos = $this->buscarFicha($id,'defun');
        $files=[];
        if($adjuntos['existe_archivo_nombre_base_tif']==true){
            $files[]=[
                
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'.tif',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_base_pdf']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'.pdf',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_a_tif']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'A.tif',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_a_pdf']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'A.pdf',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_b_tif']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'B.pdf',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_b_pdf']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'B.tif',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_c_tif']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'C.tif',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_c_pdf']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'C.pdf',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_d_tif']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'D.tif',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_d_pdf']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'D.pdf',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_e_tif']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'E.tif',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        if($adjuntos['existe_archivo_nombre_e_pdf']==true){
            $files[]=[
                'idRegistro'=>$adjuntos['idRegistro'],
                'nameFile'=>$adjuntos['nombre_base'].'E.pdf',
                'year'=>$adjuntos['año'],
                'book'=>$adjuntos['book'],
                'folio'=>$adjuntos['folio'],
            ];
        }
        return $files;
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
                    'idRegistro'=>$id,
                    'folder'=>'nacim',
                    'año'=>$data->ano_nac,
                    'book'=>$data->nro_lib,
                    'folio'=>$data->nro_fol,
                    'nombre_base'=>$nombreBase,
                ];
                break;
            case 'matri':
                $data= Matrimonio::find($id);
                $nombreBase = $data->ano_cel.$data->nro_fol;
                $archivoEncontrado=[
                    'idRegistro'=>$id,
                    'folder'=>'nacim',
                    'año'=>$data->ano_cel,
                    'book'=>$data->nro_lib,
                    'folio'=>$data->nro_fol,
                    'nombre_base'=>$nombreBase,
                ];
                break;
            case 'defun':
                $data= Defuncion::find($id);
                $nombreBase = $data->ano_des.$data->nro_fol;
                $archivoEncontrado=[
                    'idRegistro'=>$id,
                    'folder'=>'nacim',
                    'año'=>$data->ano_des,
                    'book'=>$data->nro_lib,
                    'folio'=>$data->nro_fol,
                    'nombre_base'=>$nombreBase,
                ];
                break;
            default:
                break;
        }
 
        // $fichas = Storage::disk('fichas-nacimiento')->allFiles();
        $existeArchivoNombreBaseTIF = intval(Storage::disk('fichas-'.$folder)->exists($nombreBase . '.tif'));
        $existeArchivoNombreBasePDF = intval(Storage::disk('fichas-'.$folder)->exists($nombreBase . '.pdf'));

        $existeArchivoNombreATIF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'A.TIF'));
        $existeArchivoNombreAPDF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'A.PDF'));
        $existeArchivoNombreBTIF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'B.TIF'));
        $existeArchivoNombreBPDF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'B.PDF'));
        $existeArchivoNombreCTIF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'C.TIF'));
        $existeArchivoNombreCPDF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'C.PDF'));
        $existeArchivoNombreDTIF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'D.TIF'));
        $existeArchivoNombreDPDF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'D.PDF'));
        $existeArchivoNombreETIF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'E.TIF'));
        $existeArchivoNombreEPDF = intval(Storage::disk('fichas')->exists($folder.'/'.$nombreBase . 'E.PDF'));

        $archivoEncontrado['existe_archivo_nombre_base_tif']=boolval($existeArchivoNombreBaseTIF);
        $archivoEncontrado['existe_archivo_nombre_base_pdf']=boolval($existeArchivoNombreBasePDF);
        $archivoEncontrado['existe_archivo_nombre_a_tif']=boolval($existeArchivoNombreATIF);
        $archivoEncontrado['existe_archivo_nombre_a_pdf']=boolval($existeArchivoNombreAPDF);
        $archivoEncontrado['existe_archivo_nombre_b_tif']=boolval($existeArchivoNombreBTIF);
        $archivoEncontrado['existe_archivo_nombre_b_pdf']=boolval($existeArchivoNombreBPDF);
        $archivoEncontrado['existe_archivo_nombre_c_tif']=boolval($existeArchivoNombreCTIF);
        $archivoEncontrado['existe_archivo_nombre_c_pdf']=boolval($existeArchivoNombreCPDF);
        $archivoEncontrado['existe_archivo_nombre_d_tif']=boolval($existeArchivoNombreDTIF);
        $archivoEncontrado['existe_archivo_nombre_d_pdf']=boolval($existeArchivoNombreDPDF);
        $archivoEncontrado['existe_archivo_nombre_e_tif']=boolval($existeArchivoNombreETIF);
        $archivoEncontrado['existe_archivo_nombre_e_pdf']=boolval($existeArchivoNombreEPDF);
 
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
                $nuevaDefuncion = new Defuncion();
                $nuevaDefuncion->ano_des = $request->ano_des;
                $nuevaDefuncion->ano_eje = $now->year;
                $nuevaDefuncion->nro_lib = $request->nro_lib;
                $nuevaDefuncion->nro_fol = $request->nro_fol;

                $nuevaDefuncion->ape_pat_de = $request->ape_pat_de;
                $nuevaDefuncion->ape_mat_de = $request->ape_mat_de;
                $nuevaDefuncion->nom_des = $request->nom_des;
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
                $nuevoCobro->tipo ='D';
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

    public function actualizar(Request $request)
    {
        try {

            $defuncion = Defuncion::find($request->id);

            $defuncion->ape_pat_de = $request->ape_pat_de;
            $defuncion->ape_mat_de = $request->ape_mat_de;
            $defuncion->nom_des = $request->nom_des;
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
            $newNameFile='';
            $archivoAdjuntoLength = $request->archivo_adjunto != null ? count($request->archivo_adjunto) : 0;
            if($archivoAdjuntoLength>0){
                foreach (($request->archivo_adjunto) as $key => $archivo) {
                    if ($archivo != null) {
                        // $file = $archivo->getClientOriginalName();
                        // $extension = pathinfo($file, PATHINFO_EXTENSION);
                        $newNameFile = $request->nombre_adjunto[$key];
                        Storage::disk('fichas-defun')->put($newNameFile, File::get($archivo));
        
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

    public function validarSiExisteRegistroDuplicado($ano_des, $nro_lib, $nro_fol)
    {
        $CantidadRegistrosDeDefuncion = Defuncion::where(
            [
                ['ano_des', $ano_des],
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
        $idRegistro=  $request->query('idregistro');

        $adjuntos = $this->obtenerAdjuntosLista($idRegistro);
        return view('defunciones.visualizar_adjunto_defuncion', get_defined_vars());
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

            $pathSource = Storage::disk('fichas-defun')->getDriver()->getAdapter()->applyPathPrefix($nombreArchivo);
            $destinationPath = Storage::disk('fichas-defun')->getDriver()->getAdapter()->applyPathPrefix('archivado/' . $nombreArchivo);

            // // make destination folder
            if (!File::exists(dirname($destinationPath))) {
                File::makeDirectory(dirname($destinationPath), null, true);
            }

            File::move($pathSource, $destinationPath);

            $existeArchivo = intval(Storage::disk('fichas')->exists('defun/archivado/' . $nombreArchivo));

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
