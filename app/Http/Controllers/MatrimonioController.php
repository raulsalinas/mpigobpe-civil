<?php

namespace App\Http\Controllers;

use App\Models\Matrimonio;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class MatrimonioController extends Controller
{
    public function index(Request $request)
    {


        // $tipoDocumento = DocumentoIdentidad::all();
        // $estadoCivil = EstadoCivil::all();
    
        return view('matrimonios.matrimonio', get_defined_vars());
    }

    // public function listar()
    // {
    //     $data = Nacimiento::select('nacimi.*', 
    //     'sexo.nombre AS sexo_desc',
    //     'ubigeo.nombre as ubigeo_desc'
    //     )
    //     ->leftJoin('public.sexo', 'sexo.codigo', '=', 'nacimi.sex_nac')
    //     ->leftJoin('public.ubigeo', 'ubigeo.codigo', '=', 'nacimi.ubigeo')
    //     ->where('ano_eje','>',0);

    //     return DataTables::of($data)
    //     // ->editColumn('fch_nac', function ($data) { return date('d/m/Y', strtotime($data->fch_nac)); })
    //     ->addColumn('accion', function ($data) { return 
    //         '<div class="btn-group" role="group">
    //             <button type="button" class="btn btn-xs btn-primary ver" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" ><span class="fas fa-eye"></span></button>
    //             <button type="button" class="btn btn-xs btn-default editar" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" disabled ><span class="fas fa-edit"></span></button>
    //             <button type="button" class="btn btn-xs btn-default eliminar" data-año="'.$data->ano_eje.'" data-libro="'.$data->nro_lib.'" data-folio="'.$data->nro_fol.'" disabled ><span class="fas fa-cancel"></span></button>
    //         </div>';
    //     })->rawColumns(['accion'])->make(true);
    // }

    // public function editar($anio, $libro, $folio)
    // {
    //     $data = Nacimiento::where([['ano_eje',$anio],['nro_lib',$libro],['nro_fol',$folio]])->get();
    //     return response()->json($data->first(), 200);
    // }

}
