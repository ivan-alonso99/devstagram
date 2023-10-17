<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class postController extends Controller
{
    //protejer el muro
     public function __construct()
     {
        $this->middleware('auth')->except(['show' , 'index']); // con el ->except(['show'] le decimos que solo la pagina show e indez se puede mostrar aun que no este autenticado
     }

    public function index(User $user)
    {

        $posts = Post::where('user_id', $user->id)->latest()->paginate(4);//PAginas o coleccion van de 4 en 4
        return view('dashboard', [
            'user' => $user ,       //le decimos que muestre en el link el mismo nombre de la persona quese encuentra con la sesion iniciada 
            'posts' => $posts
        ]);//muestra el muro 
        }

    public function create()
    {
     return view('posts.create');
}

    public function store(Request $request)
    {
       $this->validate($request, [
         'titulo' => 'required|max:255',
         'descripcion' => 'required',
         'imagen' => 'required',
       ]);

          //  Post::create([
          //      'titulo' => $request->titulo,
          //      'descripcion' => $request->descripcion,
          //      'imagen' => $request->imagen,
          //      'user_id' => auth()->user()->id
          //      
          //  ]);

            //otro forma de crear registros
           // $post = new Post;
           // $post ->titulo = $request->titulo;
           // $post ->descripcion = $request->descripcion;
           // $post ->imagen = $request->imagen;
           // $post ->user_id = $request->user_id;
           // $post ->save();

           //otra forma de crear registros 

           $request->user()->posts()->create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'imagen' => $request->imagen,
                'user_id' => auth()->user()->id

           ]);

            return redirect()->route('post.index', auth()->user()->username);
    }

    public function show(User $user ,Post $post) // le pasamos las dos variables que pusimos en web.php
   {
    return view('posts.show', [
        'post' => $post,                  //le pasamos la variable post
        'user' => $user      //le pasamos la variable user
    ]);
   }

   public function destroy(Post $post)
   {
         $this->authorize('delete', $post); //manda el valor del post PostPolicy.php 
         $post->delete();//si pasa la autorizacion se borrara el post 

         //Eliminar imagen
         $imagen_path = public_path('uploads/' . $post->imagen);

         if(File::exists($imagen_path)){
            unlink($imagen_path);  //si existe se eliminara con esta funcion de php 
         }

         return redirect()->route('post.index', auth()->user()->username); // se le envia al usuario de nuevo hacia sumuro depues de borrar
   }
}

