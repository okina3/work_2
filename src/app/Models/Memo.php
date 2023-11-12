<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Memo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    //Tagモデルとのリレーション（多対多）
    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'memo_tags');
    }

    //Userモデルとのリレーション（一対多）
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //自分自身のメモのデータを取得。
    /**
     * @param Builder $query
     * @return void
     */
    public function scopeAvailableMemos(Builder $query): void
    {
        $query->where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc');
    }

    // メモにリレーションされたタグを取得。
    /**
     * @param Builder $query
     * @param $id
     * @return void
     */
    public function scopeAvailableMemoInTag(Builder $query, $id): void
    {
        $query->with('tags')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc');
    }
}
