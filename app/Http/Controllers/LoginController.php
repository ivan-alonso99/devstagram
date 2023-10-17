<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth/login');
    }

    public function store(Request $request)
    {

       // dd('Autenticando...'); //dd para debuguear y esegurar que hay conexion
    $this->validate($request ,[

        'email' => 'required|email',
        'password' => 'required',

    ]);

    //con back retornamos a la misma pagina y mostramos el error 
    if(!auth()->attempt($request->only('email' , 'password'), $request->remember)) {
          return back()->with('mensaje', 'Creedenciales incorrectas');
    }
     
    return redirect()->route('post.index' , auth()->user()->username);


    }

}
