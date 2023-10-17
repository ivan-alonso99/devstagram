<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    //protejer direccion 
    public function __construct()
    {
        $this->middleware(('auth'));
    }
    //editar foto
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
    
        // Verifica si el nuevo nombre es igual al nombre actual
        if ($request->input('username') !== $user->username) {
            // Modifica el request para slugificar el nuevo nombre
            $request->request->add(['username' => Str::slug($request->username)]);
            
            // Valida el nuevo nombre
            $this->validate($request, [
                'username' => ['required', 'unique:users,username,' . $user->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil'],
            ]);
    
        // Continúa con la lógica para guardar los cambios, si es necesario
    
        // Redirige a la página deseada después de guardar los cambios
    
    if($request->imagen){ 

        $imagen = $request->file('imagen');//la imagen se queda en memoria 

        $nombreImagen = Str::uuid() . "." . $imagen->extension(); //le damos un id deferente a cada imagen 

        $imagenServidor = Image::make($imagen); // procesa la imagen intervesion image 

        $imagenServidor->fit(1000, 1000); //establecemos una tamaño a las imagenes , fit es de intervesionimage 

        $imagenPath = public_path('perfiles') . '/' . $nombreImagen; //Movemos la imagen al servidor 
        $imagenServidor->save($imagenPath);

    }
    //guardar cambios 
     $usuario = User::find(auth()->user()->id);
     $usuario->username = $request->username;
     $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
     $usuario->save();

     //redicreccionar
     return redirect()->route('post.index', $usuario->username);

  }
  


         // Si el nuevo nombre es igual al nombre actual, muestra el mensaje y redirige
     return back()->with('mensaje', 'No se realizó ningún cambio en el nombre.');


}

}