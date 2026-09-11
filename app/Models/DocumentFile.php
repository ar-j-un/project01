<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DocumentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
    ];

    public function document() : BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function getExtensionAttribute(): string
    {
        return strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
    }

    public function getIsImageAttribute(): bool
    {
        return in_array($this->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    public function getIsPdfAttribute(): bool
    {
        return $this->extension === 'pdf';
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
