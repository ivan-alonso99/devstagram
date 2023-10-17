<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

   public function posts()
    {
        return $this->hasMany(Post::class);// un usuario puede tener muchos posts s
    }

    public function likes()
    {
        return $this->hasMany(Like::class);// un usuario puede tener muchos likes 
    }

//    public function user()
//    {
//        return $this->belongsTo(User::class)->select(['name','username']);
//    }

  //almacena los seguidores de un usuario
   public function followers()
   {
      return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id'); //el metodo followers en la tabla de followers pertenece a muchos usuarios 
   }                                                                                   //en esta ocacion se especifica por que nos estamos saliendo de la convencion de laravel
   //Almacenar a los que seguimos 
   public function followings()
   {
      return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id'); 

   }

   //comprobar si un asuario ya sigue a otro 

   public function siguiendo(User $user)
   {
    return $this->followers->contains( $user->id ); //comprueba si un suario ya sigue a otro
   }
}
