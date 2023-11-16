<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];


    /**
     * @return BelongsToMany
     */
    //Memoモデルとのリレーション（多対多）
    public function memos(): BelongsToMany
    {
        return $this->belongsToMany(Memo::class, 'memo_tags');
    }


    /**
     * @param Builder $query
     * @return void
     */
    //自分自身のタグのデータを取得。
    public function scopeAvailableTags(Builder $query): void
    {
        $query->where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc');
    }


    /**
     * @param Builder $query
     * @param $request
     * @return void
     */
    //タグが重複していないか調べる。
    public function scopeAvailableTagExists(Builder $query, $request): void
    {
        $query->where('user_id', Auth::id())
            ->where('name', $request->new_tag);
    }


    /**
     * @param Builder $query
     * @param $get_url_tag
     * @return void
     */
    // タグにリレーションされたメモを取得。
    public function scopeAvailableTagInMemo(Builder $query, $get_url_tag): void
    {
        $query->with('memos')
            ->where('user_id', Auth::id())
            ->where('id', $get_url_tag)
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc');
    }
}
