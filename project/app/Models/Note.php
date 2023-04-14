<?php

namespace App\Models;

use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
    public function document() : BelongsTo {
        return $this->belongsTo(Document::class, 'document_id');
    }
    public function users() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected $guarded = [];
}