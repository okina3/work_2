<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Memo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'memo_tags');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
