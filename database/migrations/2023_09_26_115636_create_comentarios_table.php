<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //cada comentario va a almacenar el usario y el post al que pertenece //cuando un usario elimine su post tambien eliminara sus comentatios
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); //Define una clave foránea (foreign key) en la columna actual.  //cuando un usario elimine su post tambien eliminara sus comentatios
                                                         //Esto indica que la columna actual hace referencia a una columna en otra tabla.
                                                         //Especifica la tabla y la columna a la que se hace referencia en la definición de la clave foránea.
            $table->string('comentario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
