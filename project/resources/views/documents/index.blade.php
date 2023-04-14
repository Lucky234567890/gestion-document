
@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Gérer les documents</h2>
        </div>
    </div>
</div>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        <a href="http://127.0.0.1:8000/documents">{{ __('Documents') }}</a>
    </h2>
</x-slot>
<br>
<div class="container">
    <div class="container">

        <a href="{{ route('documents.create')}}" class="btn btn-success mx-auto">Créer un document</a><br>
    </div>
    <br>

    <table class="table table-hover table-responsive table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Dernière date de modification</th>
                <th>Taille du document</th>
                <th>Catérogie</th>
                <th>Type de document</th>
                <th>Version</th>
                <th>Approuvé par</th>
                <th>Labels</th>
                <th>Actions</th>
            </tr>
        </thead>
        @foreach($documents as $documents)
            <tr>
                <td>{{ $documents->nom }}{{ $documents->type_document->suffixe }}</td>
                <td>{{ $documents->dernière_date_modification }}</td>
                <td>{{ $documents->taille_document }}</td>
                <td>{{ $documents->categorie->nom }}</td>
                <td>{{ $documents->type_document->nom }}</td>
                <td>{{ $documents->version }}</td>
                <td>{{ $documents->approuvé_par }}</td>
                <td>
                    @foreach($documents->labels as $label)
                    {{ $label->nom }}
                    @endforeach
                </td>
                <td class="col-0.1">
                    <a href="{{ route('documents.show', $documents->id)}}" title="Voir les notes"><i class="fa-solid fa-pen"></i></a>
                    <a href="{{ route('documents.updatedoc', $documents->id)}}" title="oir les documents"><i class="fa-solid fa-file"></i></a>
                    <a href="{{ route('documents.download', $documents->id)}}" title="Télécharger les documents"><i class="fa-solid fa-download"></i></a>
    
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection