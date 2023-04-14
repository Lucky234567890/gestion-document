
        @extends('layouts.app')


        @section('content')
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    <a href="http://127.0.0.1:8000/documents">{{ __('Update document') }}</a>
                </h2>
            </x-slot>
            <div class="container">
                <br>
                <form action="{{ route('documents.senduploadnew', $document->id)}}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <label for="nom" class="form-label">Nom</label>
                    <input class="form-control" placeholder="Choose alternate name (optional)" required type="text" id="nom" name="nom" value="{{ $document->nom }}">
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    
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
            
                    <input type="file"
                        id="file" name="file"
                        accept=".docx,.xltx,.pdf,.png"
                        class="form-control-file mt-3 mb-3" 
                        data-browse="lol">
            
                    <input class="form-control btn btn-primary mb-3 text-black" type="submit" value="Confirmer les modifications">
                    <a class="btn btn-success" href="{{ route('note.approuve', $document->id)}}">Approuver</a>
                    
                    <a class="btn btn-primary" href="{{ route('note.augmenter', $document->id)}}">Augmenter la version</a>
                    <a class="btn btn-primary" href="{{ route('note.diminuer', $document->id)}}">Baisser la version</a>
                    <a class="btn btn-danger" href="{{ route('documents.delete', $document->id)}}">Supprimer</a>
                </form>
            </div>
        @endsection
            
        