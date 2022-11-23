<?php

namespace App\Exports;

use App\Models\Cobro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReporteCobrosExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    public function __construct( )
    {
        $this->cobros =Cobro::select('cobros.*',
        'tiprec.nombre as tipo_recibo')
        ->leftJoin('public.tiprec', 'tiprec.codigo', '=', 'cobros.tiprec')        
        ->get();
 
    }
    public function view(): View{
        

    
        return view('utilidades/imprimir_cobros', [
            'cobros'        =>  $this->cobros,
        ]);
    }

}
