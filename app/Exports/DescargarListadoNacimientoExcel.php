<?php

namespace App\Exports;

use App\Http\Controllers\ListadoDeNacimientosController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DescargarListadoNacimientoExcel implements FromView, ShouldAutoSize
{


    public function __construct(string $ano_eje ,string $nro_lib ,string $nro_fol ,string $ano_nac ,string $nom_nac ,string $ape_pat_nac ,string $ape_mat_nac ,string $nom_pad ,string $ape_pad ,string $nom_mad ,string $ape_mad ,string $fch_nac_desde ,string $fch_nac_hasta ,string $condic)
    {

        $this->ano_eje= $ano_eje;
        $this->nro_lib= $nro_lib;
        $this->nro_fol= $nro_fol;
        $this->ano_nac= $ano_nac;
        $this->nom_nac= $nom_nac;
        $this->ape_pat_nac= $ape_pat_nac; 
        $this->ape_mat_nac= $ape_mat_nac;
        $this->nom_pad= $nom_pad;
        $this->ape_pad= $ape_pad;
        $this->nom_mad= $nom_mad;
        $this->ape_mad= $ape_mad;
        $this->fch_nac_desde= $fch_nac_desde;
        $this->fch_nac_hasta= $fch_nac_hasta;
        $this->condic= $condic;
    }

    public function view(): View{

        $ano_eje = $this->ano_eje;
        $nro_lib = $this->nro_lib;
        $nro_fol = $this->nro_fol;
        $ano_nac = $this->ano_nac;
        $nom_nac = $this->nom_nac;
        $ape_pat_nac = $this->ape_pat_nac;
        $ape_mat_nac = $this->ape_mat_nac;
        $nom_pad = $this->nom_pad;
        $ape_pad = $this->ape_pad;
        $nom_mad = $this->nom_mad;
        $ape_mad = $this->ape_mad;
        $fch_nac_desde = $this->fch_nac_desde;
        $fch_nac_hasta = $this->fch_nac_hasta;
        $condic = $this->condic;
        $reporte = (new ListadoDeNacimientosController)->reporteNacimiento($ano_eje ,$nro_lib ,$nro_fol ,$ano_nac ,$nom_nac ,$ape_pat_nac ,$ape_mat_nac ,$nom_pad ,$ape_pad ,$nom_mad ,$ape_mad ,$fch_nac_desde ,$fch_nac_hasta ,$condic);
        $data=[];
        foreach($reporte as $element){

            $data[]=[
                'ano_eje'=> $element->ano_eje,
                'nro_lib'=> $element->nro_lib,
                'nro_fol'=> $element->nro_fol,
                'nom_nac'=> str_replace("'", "", str_replace("", "", $element->nom_nac)),
                'ape_pat_nac'=> str_replace("'", "", str_replace("", "", $element->ape_pat_nac)),
                'ape_mat_nac'=> str_replace("'", "", str_replace("", "", $element->ape_mat_nac)),
                'sex_nac'=> $element->sex_nac,
                'fch_nac'=> $element->fch_nac !=null ?$element->fch_nac:'',
                'ubigeo_desc'=> $element->ubigeo_desc,
                'nom_pad'=> str_replace("'", "", str_replace("", "", $element->nom_pad)),
                'ape_pad'=> str_replace("'", "", str_replace("", "", $element->ape_pad)),
                'nom_mad'=> str_replace("'", "", str_replace("", "", $element->nom_mad)),
                'ape_mad'=> str_replace("'", "", str_replace("", "", $element->ape_mad)),
                'fch_ing'=> $element->fch_ing !=null ? $element->fch_ing:'',
                'condic'=> $element->condic,
                'observa'=> $element->observa
            ];
        }
        return view('nacimientos.imprimir_lista_nacimiento_excel', [
            'data' => $data
        ]);
    }

}
