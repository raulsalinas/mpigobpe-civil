<?php

namespace App\Http\Controllers;

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
        $totalMatrimonios = 0;
        $totalDefunciones = 0;
        return view('inicio',get_defined_vars());
    }




}
