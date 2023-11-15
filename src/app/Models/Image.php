<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filename',
        'title'
    ];

    /**
     * @return BelongsTo
     */
    //Userモデルとのリレーション（一対多）
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
