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

    /**
     * @return BelongsToMany
     */
    //Tagモデルとのリレーション（多対多）
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'memo_tags');
    }

    /**
     * @return BelongsTo
     */
    //Userモデルとのリレーション（一対多）
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //Imageモデルとのリレーションの記述
    /**
     * @return BelongsTo
     */
    public function imageFirst(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image1');
    }

    /**
     * @return BelongsTo
     */
    public function imageSecond(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image2');
    }

    /**
     * @return BelongsTo
     */
    public function imageThird(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image3');
    }

    /**
     * @return BelongsTo
     */
    public function imageFourth(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image4');
    }

    /**
     * @param Builder $query
     * @return void
     */
    //自分自身のメモのデータを取得。
    public function scopeAvailableMemos(Builder $query): void
    {
        $query->where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc');
    }

    /**
     * @param Builder $query
     * @param $id
     * @return void
     */
    // メモにリレーションされたタグを取得。
    public function scopeAvailableMemoInTag(Builder $query, $id): void
    {
        $query->with('tags')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc');
    }
}
