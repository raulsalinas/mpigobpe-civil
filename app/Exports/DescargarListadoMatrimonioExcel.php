<?php

namespace App\Exports;

use App\Http\Controllers\ListadoDeMatrimoniosController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class descargarListadoMatrimonioExcel implements FromView, ShouldAutoSize
{


    public function __construct(string $ano_eje,string $nro_lib,string $nro_fol,string $ape_mar,string $nom_mar,string $ape_esp,string $nom_esp,string $fch_cel_desde,string $fch_cel_hasta,string $condic)
    {

        $this->ano_eje = $ano_eje;
        $this->nro_lib = $nro_lib;
        $this->nro_fol = $nro_fol;
        $this->ape_mar = $ape_mar;
        $this->nom_mar = $nom_mar;
        $this->ape_esp = $ape_esp;
        $this->nom_esp = $nom_esp;
        $this->fch_cel_desde = $fch_cel_desde;
        $this->fch_cel_hasta = $fch_cel_hasta;
        $this->condic = $condic;
    }

    public function view(): View{

        $ano_eje = $this->ano_eje;
        $nro_lib = $this->nro_lib;
        $nro_fol = $this->nro_fol;
        $ape_mar = $this->ape_mar;
        $nom_mar = $this->nom_mar;
        $ape_esp = $this->ape_esp;
        $nom_esp = $this->nom_esp;
        $fch_cel_desde = $this->fch_cel_desde;
        $fch_cel_hasta = $this->fch_cel_hasta;
        $condic = $this->condic;

        $reporte = (new ListadoDeMatrimoniosController)->reporteMatrimonio($ano_eje,$nro_lib,$nro_fol,$ape_mar,$nom_mar,$ape_esp,$nom_esp,$fch_cel_desde,$fch_cel_hasta,$condic);
        $data=[];
        foreach($reporte as $element){

            $data[]=[
                'ano_eje'=> $element->ano_eje,
                'nro_lib'=> $element->nro_lib,
                'nro_fol'=> $element->nro_fol,
                'ape_mar'=> str_replace("'", "", str_replace("", "", $element->ape_mar)),
                'nom_mar'=> str_replace("'", "", str_replace("", "", $element->nom_mar)),
                'ubigeo_marido'=> $element->ubigeo_marido,
                'ape_esp'=> str_replace("'", "", str_replace("", "", $element->ape_esp)),
                'nom_esp'=> str_replace("'", "", str_replace("", "", $element->nom_esp)),
                'ubigeo_esposa'=> $element->ubigeo_esposa,
                'usuario'=> $element->usuario,
                'fch_cel'=> $element->fch_cel,
                'fch_reg'=> $element->fch_reg,
                'condic'=> $element->condic,
                'observa'=> $element->observa
            ];
        }
        return view('matrimonios.imprimir_lista_matrimonio_excel', [
            'data' => $data
        ]);
    }

}
