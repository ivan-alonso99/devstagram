<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash; //hashear contraseña

class RegisterController extends Controller //muestra los datos guardados en la carpeta de auth y archivo register
{
    //
    public function index() {  
        return view('auth.register');
    }

   public function store(Request $request)  //Guarda los datos ingresados 
   {
     //dd($request);

    // dd($request->get('username')); // acceder directamente a un valor 

    //Modificar el request
    $request->request->add(['username' => Str::slug($request->username)]);

    //validacion 
    $this->validate($request, [
        'name' => 'required|min:5',
        'username' => 'required|unique:users|min:3|max:20',
        'email' => 'required|unique:users|email|max:60',
        'password' => 'required|confirmed',
        
    ]);

    User::create([
        'name' => $request->name,
        'username' => Str::slug($request->username),
        'email' => $request->email,
        'password' => $request->password,

        //hashear la contraseña 
    //'password' => Hash::make($request->password),

    ]);

    //Autenticar un usuario
   // auth()->attempt([
   //     'email' => $request->email,
   //     'password' => $request->password,
   // ]);

    //otra forma de autenticar 
    auth()->attempt($request->only('email','password'));
    //Redireccionar
    return redirect()->route('post.index', auth()->user()->username);

     
   }
}
