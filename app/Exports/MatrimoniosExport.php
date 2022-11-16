<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MatrimoniosExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    public function __construct( object $matrimonios, string $descripcionFiltro)
    {
        $this->matrimonios =$matrimonios ;
        $this->descripcionFiltro = $descripcionFiltro;
 
    }
    public function view(): View{
 
    
        return view('matrimonios/imprimir_consistencia_matrimonios_excel', [
            'matrimonios'        =>  $this->matrimonios,
            'descripcionFiltro'        =>   $this->descripcionFiltro,
         ]);
    }

}
