<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
     $this->middleware('auth'); // para ver la pagina principal tiene que estar autenticados     
    }

    //mostrar publicaciones de los que seguimos 
   public function __invoke()
   {
       //obtener a quienes seguimos 
       $ids = auth()->user()->followings->pluck('id')->toArray();//pluck no trae ciertos cambios 
       $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);   //busca los id que estamos siguiendo y los enpagina , latest ordena de la nueva a la mas vieja 

      return view('home', [               // le pasamos la vista de home que se encuentra en view
          'posts' => $posts    
   ]);  

   }
}
