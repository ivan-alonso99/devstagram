<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //seguir al alguien 
    public function store(User $user, Request $request)
    {
        $user->followers()->attach( auth()->user()->id );     //attach cuando se tenga una relacion de muchos a muchos 
        return back();   
    }


    //seguir al alguien 
    public function destroy(User $user, Request $request)
    {
        $user->followers()->detach( auth()->user()->id );     //attach cuando se tenga una relacion de muchos a muchos 
        return back();   
    }

}
