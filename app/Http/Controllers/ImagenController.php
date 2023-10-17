<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //almacen de imagenes 
    public function store(Request $request)
    {
         $imagen = $request->file('file');//la imagen se queda en memoria 

        $nombreImagen = Str::uuid() . "." . $imagen->extension(); //le damos un id deferente a cada imagen 

        $imagenServidor = Image::make($imagen); // procesa la imagen intervesion image 

        $imagenServidor->fit(1000, 1000); //establecemos una tamaño a las imagenes , fit es de intervesionimage 

        $imagenPath = public_path('uploads') . '/' . $nombreImagen; //Movemos la imagen al servidor 
        $imagenServidor->save($imagenPath);

         return response()->json(['imagen'=> $nombreImagen]);
    }

}
