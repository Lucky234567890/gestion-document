<?php

namespace App\Http\Controllers;

use App\Models\note;
use App\Models\label;
use App\Models\document;
use App\Models\categorie;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\type_document;
use App\Models\document_label;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index() {
        $i = 1;
        $documents = document::all();

        function convertir_taille($octets) {
            $unite = array('octets', 'Ko', 'Mo', 'Go');
            return round($octets / pow(1024, ($i = floor(log($octets, 1024)))), 2) . ' ' . $unite[$i];
        }

        foreach($documents as $document) {
            $document->taille_document = convertir_taille($document->taille_document);
        }

        
        return view('documents.index', compact('documents', 'i'));
    }
    public function create() {
        $i = 1;
        $documents = document::all();
        $type_document = type_document::all();
        $categorie = categorie::all();
        $labels = label::all();


        return view('documents.create', compact('documents', 'i', 'type_document', 'categorie', 'labels'));
    }
    public function uploadnew(Request $request) :  RedirectResponse
    {
        $type = DB::table('type_documents')->where('description', $request->file->extension())->first();
        $nameoriginalfile = basename($request->file('file')->getClientOriginalName(), '.'.$request->file('file')->getClientOriginalExtension());

        $i = 1;
        $documents = document::all();
        $document = document::create([
            'nom' => isset($request->nom)?$request->nom:$nameoriginalfile,
            'dernière_date_modification' => date("Y-m-d H:i:s"),
            'taille_document' => $request->file('file')->getSize(),
            'version' => 1,
            'documen_prive' => 1,
            'approuvé_par' => '',
            'type_documents_id' => $type->id,
            'categorie_id' => $request->categorie
        ]);
        $data = $request->all();
        $selected_value = $data['label'];
        
        foreach($selected_value as $value){
            document_label::create([
                'documents_id' => $document->id,
                'labels_id' => $value
            ]);
        }

        $filename = $document->id . '.' . $request->file->extension();

        $request->file->storeAs(
            'documents',
            $filename
        );

        return redirect('/documents');

    }
    public function show($id) {
        $document = document::find($id);
        $i = 1;
        return view('documents.show', compact('document', 'i'));
    }
    public function delete($id) {
        $type = DB::table('documents')->where('id', $id)->first()->type_documents_id;
        $type = DB::table('type_documents')->where('id', $type)->first()->suffixe;

        $pathToFile = 'documents/' . $id . $type;
        Storage::delete($pathToFile);

        $document = document::find($id);
        $document->delete();
        

        return redirect('/documents');

        
    }
    public function notecreate($id, Request $request) {
        note::create([
            'texte' => $request->text,
            'sujet' => $request->sujet,
            'dernière_date_modication' => date("Y-m-d H:i:s"),
            'user_id' => Auth::user()->id,
            'document_id' => $id


        ]);
        
        return redirect('/documents/show/' . $id);

        
    }
    public function noteshow($id, Request $request) {
        note::create([
            'texte' => $request->text,
            'sujet' => $request->sujet,
            'dernière_date_modication' => date("Y-m-d H:i:s"),
            'user_id' => Auth::user()->id,
            'document_id' => $id
        ]);

        return redirect('/documents');

        
    }
    public function updatenote($id, Request $request, $id2) {
        $note = note::find($id);

        $note->texte = $request->text;
        $note->sujet = $request->sujet;
        $note->dernière_date_modication = date("Y-m-d H:i:s");
        $note->user_id = Auth::user()->id;
        $note->save();

        return redirect('/documents/show/' . $id2);
    }
    public function notedelete($id, Request $request, $id2) {
        $note = note::find($id);

        $note->delete();

        return redirect('/documents/show/' . $id2);
    }
    public static function approuve($id, Request $request) {
        if (empty(document::find($id)->approuvé_par) ) {
            $document = document::find($id);
            $document->approuvé_par =  Auth::user()->name;
            $document->save();

            
        } else {
            if (document::find($id)->approuvé_par = Auth::user()->id) {
                $document = document::find($id);
                $document->approuvé_par = "";
                $document->save();
            } else {
                $document = document::find($id);
                $document->approuvé_par =  Auth::user()->name;
                $document->save();
            }
        }
        
        return redirect('/documents');

    }
    public function augmenter($id, Request $request) {
        $valeur = document::find($id)->version;
        $valeur = $valeur + 1;
        $document = document::find($id);
        $document->version = $valeur;
        $document->save();


        
        return redirect('/documents');

    }
    public function diminuer($id, Request $request) {
        $valeur = document::find($id)->version;
        if ($valeur > 1) {
            $valeur = $valeur - 1;
            $document = document::find($id);
            $document->version = $valeur;
            $document->save();

        }


        
        return redirect('/documents');

    }
    public function prive($id, Request $request) {
        $valeur = document::find($id)->version;
        $valeur = $valeur + 1;
        $document = document::find($id);
        $document->version = $valeur;
        $document->save();


        
        return redirect('/documents');

    }
    public function updatedoc($id, Request $request) : View {
        $document = document::find($id);
        $type_document = type_document::all();
        $categorie = categorie::all();
        $labels = label::all();



        return view('documents.updatedoc', compact('document', 'type_document', 'categorie', 'labels'));

    }
    public function sendupdatedoc($id, Request $request) {
        $document = document::find($id);
        
        $document->nom = $request->nom;
        $document->categorie_id = $request->categorie;


        
        
        
        
        if ($request->file) {
            $type = DB::table('type_documents')->where('description', $request->file->extension())->first();
            $document->taille_document = $request->file('file')->getSize();
            $document->type_documents_id = $type->id;
            
            $type = DB::table('documents')->where('id', $id)->first()->type_documents_id;
            $type = DB::table('type_documents')->where('id', $type)->first()->suffixe;

            $pathToFile = 'documents/' . $id . $type;
            Storage::delete($pathToFile);

            $filename = $document->id . '.' . $request->file->extension();

            $request->file->storeAs(
                'documents',
                $filename
            );
        } else {
        }


        
        $document->save();

        
        $data = $request->all();
        $selected_value = $data['label'];
        
        DB::table('document_labels')->where('documents_id', '=', $id)->delete();
        foreach($selected_value as $value){
            document_label::create([
                'documents_id' => $id,
                'labels_id' => $value
            ]);
        }

        return redirect('/documents');

    }
    public function makeprivate($id) {
        $document = document::find($id);
        $document->documen_prive = Auth::user()->username;
        $document->save();
    }
    public function download($id) {
        $type = DB::table('documents')->where('id', $id)->first()->type_documents_id;
        $type = DB::table('type_documents')->where('id', $type)->first()->suffixe;

        $pathToFile = storage_path('app\\documents\\' . $id . $type);
        return response()->download($pathToFile);
        
    }

}
