<?php

namespace App\Helpers;
use Illuminate\Http\Request;

use App\Models\Defuncion;
use App\Models\FichasDefuncion;
use App\Models\FichasMatrimonio;
use App\Models\FichasNacimiento;
use App\Models\Matrimonio;
use App\Models\Nacimiento;
use Carbon\Carbon;
use Exception;

class AdjuntoHelper
{
    public static function obtenerAdjuntos($id, $ruta)
    {

        switch ($ruta) {
            case 'nacimientos':
                $fichas = FichasNacimiento::where('nacimi_id', $id)->get();
                break;

            case 'matrimonios':
                $fichas = FichasMatrimonio::where('matrim_id', $id)->get();

                break;

            case 'defunciones':
                $fichas = FichasDefuncion::where('defun_id', $id)->get();

                break;

            default:
                return $fichas = [];
                break;
        }
        return $fichas;

        // $archivoEncontrado = [
        //     'idRegistro' => '67724',
        //     'folder' => 'nacim',
        //     'año' => '2023',
        //     'book' => '01',
        //     'folio' => '3006125195',
        //     'nombre_base' => '20223006125195',
        //     'condic' =>'1',
        //     'existe_archivo_nombre_base_tif' =>true
        // ];

        // return $archivoEncontrado;
    }

    public static function obtenerAnoLibroFolioDeAdjunto($idRegistro, $idArchivo = null, $tipo)
    {

        $registro = [];
        switch ($tipo) {
            case 'nacimientos':
                if ($idArchivo >0) {
                    $ficha = FichasNacimiento::where('id', $idArchivo)->first();
                    $registro = Nacimiento::with('condicion')->where('id', $ficha->nacimi_id)->first();
                } else {
                    $registro = Nacimiento::with('condicion')->where('id', $idRegistro)->first();
                }

                break;

            case 'matrimonios':
                if ($idArchivo >0) {
                    $ficha = FichasMatrimonio::where('id', $idArchivo)->first();
                    $registro = Matrimonio::with('condicion')->where('id', $ficha->matrim_id)->first();
                } else {
                    $registro = Matrimonio::with('condicion')->where('id', $idRegistro)->first();
                }
                break;

            case 'defunciones':
                if ($idArchivo >0) {
                    $ficha = FichasDefuncion::where('id', $idArchivo)->first();
                    $registro = Defuncion::with('condicion')->where('id', $ficha->defun_id)->first();
                } else {
                    $registro = Defuncion::with('condicion')->where('id', $idRegistro)->first();
                }
                break;

            default:
                return  ['ano' => 'S/n', 'libro' => 'S/n', 'folio' => 'S/n','condicion' => 'S/c'];
                break;
        }

        return  ['ano' => $registro->ano_eje, 'libro' => $registro->nro_lib, 'folio' => $registro->nro_fol, 'condicion' => $registro->condicion? $registro->condicion->nombre:''];
    }

    public static function anularAdjunto(Request $request)
    {
        try {
            $respuesta = '';
            $alerta = 'warning';
            $mensaje = 'Hubo un problema';
            $error = '';

            switch ($request->tipo) {
                case 'nacimientos':
                    $ficha = FichasNacimiento::where('id', $request->id_archivo)->first();
                    $ficha->deleted_at= Carbon::now();
                    $ficha->save();
                    $respuesta = 'ok';
                    $alerta = 'success';
                    break;
                
                case 'matrimonios':
                    $ficha = FichasMatrimonio::where('id', $request->id_archivo)->first();
                    $ficha->deleted_at= Carbon::now();
                    $ficha->save();
                    $respuesta = 'ok';
                    $alerta = 'success';
                    break;
                
                case 'defunciones':
                    $ficha = FichasDefuncion::where('id', $request->id_archivo)->first();
                    $ficha->deleted_at= Carbon::now();
                    $ficha->save();
                    $respuesta = 'ok';
                    $alerta = 'success';
                    break;
                
                default:
                    # code...
                    break;
            }
            $mensaje = 'El archivo fue anulado';

            // $nombreArchivo =  $request->nombreArchivo;
            // $data = Nacimiento::find($request->idRegistro);
            // $carpetaPadre= $this->getCarpetaPadreCondicion($data->condic);
            // $ruta = 'fichas-'.$carpetaPadre.'-nacim';
            // $pathSource = Storage::disk($ruta)->getDriver()->getAdapter()->applyPathPrefix($nombreArchivo);
            // $destinationPath = Storage::disk($ruta)->getDriver()->getAdapter()->applyPathPrefix('archivado/' . $nombreArchivo);
            // if (!File::exists(dirname($destinationPath))) {
            //     File::makeDirectory(dirname($destinationPath), null, true);
            // }
            // File::move($pathSource, $destinationPath);
            // $existeArchivo = intval(Storage::disk($ruta)->exists('archivado/' . $nombreArchivo));
            // if ($existeArchivo == true) {
            //     $respuesta = 'ok';
            //     $alerta = 'success';
            //     $mensaje = 'El archivo adjunto fue archivado';
            // } else {
            //     $alerta = 'warning';
            //     $mensaje = 'success';
            //     $mensaje = 'Hubo un problema al intentar archivar el archivo';
            // }
        } catch (Exception $ex) {
            $respuesta = 'error';
            $alerta = 'error';
            $mensaje = 'Hubo un problema al intentar archivar el archivo. Por favor intente de nuevo';
            $error = $ex;
        }
        return response()->json(array('respuesta' => $respuesta, 'alerta' => $alerta, 'mensaje' => $mensaje, 'error' => $error), 200);
    }
}
