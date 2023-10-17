<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    public function mount($post)  // vuelve dinamica los likes , mount solo monta el componenete abajo se le tiene que asignar una funcion
    {
        $this->isLiked = $post->checkLike(auth()->user()); //checa si ya se le dio like a la publicacion
        $this->likes = $post->likes->count(); //cueta los likes 
    }

    public function like()
    {
        if($this->post->checkLike(auth()->user())){
            $this->post->likes()->where('post_id', $this->post->id)->delete();// filtramos el post actual donde estamos eliminando el like 
            $this->isLiked = false;
            $this->likes--;

        }else{
            $this->post->likes()->create([
                'user_id' =>  auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }


    public function render()
    {
        return view('livewire.like-post');
    }
}
