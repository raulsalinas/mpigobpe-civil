<?php

namespace App\Http\Controllers;

use App\Models\Defuncion;
use App\Models\Matrimonio;
use App\Models\Nacimiento;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalNacimientos = Nacimiento::count();
        $totalMatrimonios = Matrimonio::count();
        $totalDefunciones = Defuncion::count();
        return view('inicio',get_defined_vars());
    }




}
