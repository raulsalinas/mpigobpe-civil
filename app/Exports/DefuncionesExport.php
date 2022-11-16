<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DefuncionesExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     //
    // }
    public function __construct(object $defunciones, string $descripcionFiltro)
    {
        $this->defunciones = $defunciones;
        $this->descripcionFiltro = $descripcionFiltro;
    }
    public function view(): View
    {


        return view('defunciones/imprimir_consistencia_defunciones_excel', [
            'defunciones'        =>  $this->defunciones,
            'descripcionFiltro'  =>   $this->descripcionFiltro,
        ]);
    }
}
