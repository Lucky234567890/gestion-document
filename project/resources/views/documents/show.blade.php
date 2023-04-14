@extends('layouts.app')


@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create a note') }}
    </h2>
</x-slot>
<form action="{{route('note.create', $document->id)}}">
    <div class="container">
        <br>
        @csrf
        <label class="form-label" for="sujet">Sujet</label>
        <input class="form-control" required type="text" id="sujet" name="sujet">
        <label class="form-label"  for="text">Text</label>
        <input  class="form-control" required type="text" id="text" name="text">
        <input class="btn btn-primary btn-outline active mt-3 mx-auto d-block" required type="submit" value="Envoyer">
        <br>
    </form> 
    @foreach($document->notes as $notes)
        <hr style="color: #C7C7C7; height: 1.5px; background-color: #C7C7C7;" >
        <form style="margin: 0px;" style="margin: 0px" action="{{ route('note.updatenote', ['id' => $notes->id, 'id2' => $document->id]) }}">
            <p class="fw-bold">Note {{ $i++ }}</p>
            <label class="form-label" required for="sujet">Sujet</label>
            <input class="form-control" type="text" id="sujet" name="sujet" value="{{ $notes->sujet }}">
            <label  class="form-label" for="text">Text</label>
            <input class="form-control" required type="text" id="text" name="text" value="{{ $notes->texte }}">
            <input class="btn btn-primary btn-outline active mt-3 mt-3 mx-auto d-block" type="submit" value="Confirmer les modifications">
        </form>
        <form style="margin: 0px;" action="{{route('note.delete', ['id' => $notes->id, 'id2' => $document->id])}}" style="margin: 0px">
            <input class="btn btn-danger btn-outline active mt-3 mx-auto d-block" type="submit" value="Supprimer les notes" >
        </form>
        <p class="mx-auto d-block">Note de {{ $notes->users->name }}</p>
    @endforeach
    </div>
@endsection