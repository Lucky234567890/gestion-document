<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Label;
use App\Models\Categorie;
use App\Models\Type_document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    use HasFactory;
    
    public function notes() : HasMany {
        return $this->hasMany(Note::class);
    }
    public function categorie() : BelongsTo {
        return $this->belongsTo(Categorie::class);
    }
    public function type_document() : BelongsTo {
        return $this->belongsTo(Type_document::class, 'type_documents_id');
    }
    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'document_labels', 'documents_id', 'labels_id');
    }
    protected $guarded = [];

    public $timestamps = false;

}
