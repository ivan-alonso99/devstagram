<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    //Agregamos la ruta sotre puesta previamente en web.php , se pueden poner la variables aunque no se usen por ejemplo User 
    public function store(Request $request, User $user , Post $post)
    {
        //validar
        $this->validate($request, [
           'comentario' => 'required|max:255'
        ]);

        //alamacenar  
         Comentario::create([
         'user_id' => auth()->user()->id ,
         'post_id' => $post->id,
         'comentario' => $request->comentario
         ]);


        //Imprimir mensaje
        //los with se impriment con una sesion en show.blade
        return back()->with('mensaje', 'Comentario realizado correctamente');
    }
}
