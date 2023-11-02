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

    //Memoモデルとのリレーション（多対多）
    public function memos(): BelongsToMany
    {
        return $this->belongsToMany(Memo::class, 'memo_tags');
    }

    //自分自身のタグのデータを取得。
    public function scopeAvailableTags(Builder $query): void
    {
        $query->where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc');
    }

    //タグを保存し、中間テーブルにもデータを入れる。
    public function scopeAvailableTagCreate(Builder $query, $request, $memo, $tag_exists): void
    {
        if (!empty($request->new_tag) && !$tag_exists) {
            //タグを保存。
            $tag = $query->create([
                'name' => $request->new_tag,
                'user_id' => Auth::id()
            ]);
            //中間テーブルに保存。
            MemoTag::create([
                'memo_id' => $memo->id,
                'tag_id' => $tag->id
            ]);
        }
    }

    //タグが重複していないか調べる。
    public function scopeAvailableTagExists(Builder $query, $request): void
    {
        $query->where('user_id', Auth::id())
            ->where('name', $request->new_tag);
    }

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
