<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NacimientosExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    public function __construct( object $nacimientos, string $descripcionFiltro)
    {
        $this->nacimientos =$nacimientos ;
        $this->descripcionFiltro = $descripcionFiltro;
 
    }
    public function view(): View{
 
    
        return view('nacimientos/imprimir_consistencia_nacimientos_excel', [
            'nacimientos'        =>  $this->nacimientos,
            'descripcionFiltro'        =>   $this->descripcionFiltro,
         ]);
    }

}
