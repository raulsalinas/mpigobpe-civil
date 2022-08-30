<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->unique();    // ealvarez
            $table->string('correo')->nullable();   // programador2@okc
            $table->string('password');             // inicio01
            $table->string('nombre_largo');         // Edgar Alvarez Valdez
            $table->string('nombre_corto');         // Edgar Alvarez
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public.usuarios');
    }
}