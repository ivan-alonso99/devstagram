<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\postController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {  //muestra la vista llamada principal , controloador tipo closure 
 //    return view('principal');
//});

Route::get('/', HomeController::class)->name('home');  //Utiliza __invoke que funciona como un constructor en homecontroller

Route::get('/register', [RegisterController::class,'index'])->name('crear-cuenta');   // muestra la vista index que se encuentra en registercontroller y le asigna un nombre en el enlace
Route::post('/register', [RegisterController::class,'store']); // guarda los datos de store que se encuentra en register controller 

route::get('/login', [LoginController::class, 'index'])->name('login');//muestra el login para iniciar sesion 
route::post('/login', [LoginController::class, 'store']);//autenticar login 
route::post('/logout', [LogoutController::class, 'store'])->name('logout'); //cerrar sesion 

//rutas para el perfil 
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');


Route::get('/{user:username}',[postController::class, 'index'])->name('post.index'); // muestra el muro , he muestra el nombre del usuario que inicio sesion en la parte superior 
Route::get('/posts/create', [postController::class, 'create'])->name('posts.create');
Route::post('/posts', [postController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}' , [postController::class, 'show'])->name('posts.show');//Difinimos laruta con dos variables una que muestra el post y otro que muestra el usario del post

Route::delete('/posts/{post}', [postController::class, 'destroy'])->name('post.destroy');//Eliminar publicaciones 

Route::post('/{user:username}/posts/{post}' , [ComentarioController::class, 'store'])->name('comentarios.store');

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

//Like a las fotos 
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.like.store');
   
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.like.destroy'); // borramos el like


//siguiendo usuarios 
Route::post('/{user:username}/follow',[FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow',[FollowerController::class, 'destroy'])->name('users.unfollow'); // eliminar el follow    
