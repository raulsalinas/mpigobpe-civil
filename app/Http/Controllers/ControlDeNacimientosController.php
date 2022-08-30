<?php

namespace App\Http\Controllers;

use App\Models\CentroAsistencial;
use App\Models\Nacimiento;
use App\Models\TipoRegistro;
use App\Models\Ubigeo;
use Illuminate\Http\Request;

class ControlDeNacimientosController extends Controller
{
    public function index(Request $request)
    {
        $controlAsistencialList = $this->controlAsistencialList();
        $ubigeoList = $this->ubigeoList();
        $tipoRegistroList = $this->tipoRegistroList();

        return view('nacimientos.control_de_nacimientos', get_defined_vars());
    }

    public function ver($año, $libro, $folio)
    {
        $data = Nacimiento::where([['ano_eje',$año],['nro_lib',$libro],['nro_fol',$folio]])->get();
        return response()->json($data->first(), 200);
    }

    public function controlAsistencialList(){
        $data = CentroAsistencial::where('codigo','!=',null)->get();
        return $data;
    }
    public function ubigeoList(){
        $data = Ubigeo::where('codigo','!=',null)->get();
        return $data;
    }
    public function tipoRegistroList(){
        $data = TipoRegistro::where('codigo','!=',null)->get();
        return $data;
    }


    public function verActaAdverso(Request $request)
    {
        return view('nacimientos.acta_de_nacimiento_adverso', get_defined_vars());
    }
    public function verActaReverso(Request $request)
    {
        return view('nacimientos.acta_de_nacimiento_reverso', get_defined_vars());
    }
}
