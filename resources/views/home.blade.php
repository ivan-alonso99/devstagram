@extends('layouts.app')

@section('titulo')
     DevStagram
@endsection


@section('contenido')
       
       <!-- Haciendo uso de un componenete de laravel    --> 
         <!-- Utilizadno un slot el cual se utiliza para llamara un compoenente desde listar-post -->
          <!-- Le pasamos la variable de post -->
      <x-listar-post :posts="$posts"/>
        
     
@endsection 