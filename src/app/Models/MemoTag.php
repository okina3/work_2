<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'memo_id',
        'tag_id',
    ];

    public $timestamps = false;

    //既存タグが選択されていたら、メモに紐付け保存する。
    public function scopeAvailableMemoTagCreate(Builder $query, $memo, $tag_number): void
    {
        $query->create([
            'memo_id' => $memo->id,
            'tag_id' => $tag_number
        ]);
    }
}
