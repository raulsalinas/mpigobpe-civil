<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('public.usuarios')->insert([
            'usuario'           => 'muni',
            'correo' 		    => 'octavio.ly@gmail.com',
            'password' 		    => Hash::make('@glorieta'),
            'nombre_largo' 		=> 'Municipalidad Ilo',
            'nombre_corto' 		=> 'Muni',
            'remember_token'    => Str::random(10),
            'created_at'	    => date('Y-m-d H:i:s'),
            'updated_at'	    => date('Y-m-d H:i:s')
        ]);
    }
}
