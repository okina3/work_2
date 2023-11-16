<?php

namespace App\Services;

use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagService
{
   /**
    * @param $request
    * @param $memo
    * @return void
    */
   //新規タグ、既存タグの保存、更新。
   public static function tagCreate($request, $memo): void
   {
      //もし、既存タグの選択があれば、メモに紐付け、中間テーブルに保存する。
      if (!empty($request->tags)) {
         foreach ($request->tags as $tag_number) {
            Memo::findOrFail($memo->id)->tags()->attach($tag_number);
         }
      }

      //新規タグの入力があった場合,タグが重複していないか調べる。
      $tag_exists = Tag::availableTagExists($request)->exists();

      //新規タグがあり、重複していなれば、タグと中間テーブルに保存。
      if (!empty($request->new_tag) && !$tag_exists) {
         //タグを保存。
         $tag = Tag::create([
            'name' => $request->new_tag,
            'user_id' => Auth::id()
         ]);
         //中間テーブルに保存。
         Tag::findOrFail($tag->id)->memos()->attach($memo->id);
      }
   }


   /**
    * @param $id
    * @return array
    */
   //選択したメモに紐づいたタグを取得。
   public static function memoRelationTags($id): array
   {
      $memo_relation = Memo::availableMemoInTag($id)->first();
      $memo_relation_tags = [];
      foreach ($memo_relation->tags as $memo_relation_tag) {
         $memo_relation_tags[] = $memo_relation_tag->id;
      }

      return $memo_relation_tags;
   }
}
