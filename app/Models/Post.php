<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'type', 'province_id', 'musician_type_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function musicianType(): BelongsTo
    {
        return $this->belongsTo(MusicianType::class);
    }

}
