<?php

namespace App\Exports;

use App\Http\Controllers\ListadoDeDefuncionesController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class descargarListadoDefuncionExcel implements FromView, ShouldAutoSize
{


    public function __construct(string $ano_eje,string $nro_lib,string $nro_fol,string $ape_des, string $nom_des, string $fch_des_desde, string $fch_des_hasta, string $condic)
    {
        $this->ano_eje = $ano_eje;
        $this->nro_lib = $nro_lib;
        $this->nro_fol = $nro_fol;
        $this->ape_des = $ape_des;
        $this->nom_des = $nom_des;
        $this->fch_des_desde = $fch_des_desde;
        $this->fch_des_hasta = $fch_des_hasta;
        $this->condic = $condic;
    }

    public function view(): View{
        $ano_eje= $this->ano_eje;
        $nro_lib=  $this->nro_lib;
        $nro_fol = $this->nro_fol;
        $ape_des = $this->ape_des;
        $nom_des = $this->nom_des;
        $fch_des_desde = $this->fch_des_desde;
        $fch_des_hasta = $this->fch_des_hasta;
        $condic = $this->condic;
        $reporte = (new ListadoDeDefuncionesController)->reporteDefuncion($ano_eje,$nro_lib,$nro_fol,$ape_des,$nom_des,$fch_des_desde,$fch_des_hasta,$condic);
        $data=[];
        foreach($reporte as $element){

            $data[]=[
                'ano_eje'=> $element->ano_eje,
                'nro_lib'=> $element->nro_lib,
                'nro_fol'=> $element->nro_fol,
                'ape_des'=> str_replace("'", "", str_replace("", "", $element->ape_des)),
                'nom_des'=> str_replace("'", "", str_replace("", "", $element->nom_des)),
                'motivo_defuncion'=> $element->motivo_defuncion,
                'fch_des'=> $element->fch_des,
                'usuario'=> $element->usuario,
                'fch_reg'=> $element->fch_reg,
                'observa'=> $element->observa
            ];
        }
        return view('defunciones.imprimir_lista_defuncion_excel', [
            'data' => $data
        ]);
    }

}
