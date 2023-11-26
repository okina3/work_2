<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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


    /**
     * @param Builder $query
     * @return void
     */
    //自分自身の画像のデータを取得。
    public function scopeAvailableImages(Builder $query): void
    {
        $query->where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc');
    }
}
