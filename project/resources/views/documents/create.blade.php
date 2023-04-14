
@extends('layouts.app')


@section('content')
<div class="row">    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Créer un document') }}
    </h2>
</x-slot>
<form action="{{ route('documents.uploadnew')}}" method="post" enctype="multipart/form-data">
    @csrf
    <br>
    <div class="container" >

        <label class="form-label mb-0" for="nom" >Nom</label><br>
        <input placeholder="Nom (optionnel)" class="form-control" type="text" id="nom" name="nom" >
        <x-input-error :messages="$errors->get('nom')" class="mt-2"/>
        
        <label class="form-label">Catégorie</label>
        <select class="form-select" name="categorie" id="categorie">
            @foreach($categorie as $categorie)
            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
            @endforeach
        </select>
        <label class="form-label">Label</label>
        <select class="form-select" name="label[]" id="label" multiple required>
            @foreach($labels as $label)
            <option value="{{ $label->id }}">{{ $label->nom }}</option>
            @endforeach
        </select>
        <label class="form-label" for="file">Choissez un fichier :</label>

        <input class="form-control" type="file" required
            value="Choose a file"
            id="file" name="file"
            accept=".docx,.xltx,.pdf,.png">

        <input type="submit" class="btn btn-primary btn-outline active mt-3 mx-auto d-block">
    </div>
</form>

@endsection