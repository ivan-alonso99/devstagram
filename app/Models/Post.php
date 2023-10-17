<?php

namespace App\Models;

use App\Models\Comentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name' , 'username']);
    }

    public function comentarios()
    {
        //Un post va a tener multiples comentarios (hasMany) y se importa la clase comentario (Comentario::class   )
         return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        return $this->likes->contains('user_id', $user->id);//se posiciona en la tabla de likes y utilizando contains dice "la tabla de likes contiene en la columna de user_id este usuario"
    }
}
