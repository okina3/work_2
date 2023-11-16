<?php

namespace App\Services;

use App\Models\Memo;
use App\Models\Tag;

class MemoService
{
   /**
    * @return mixed
    */
   //全メモ、また、検索したメモを表示する。
   public static function memoSearchAll(): mixed
   {
      //クエリパラメータを取得。
      $get_url_tag = \Request::query('tag');

      //もしクエリパラメータがあれば、タグから絞り込む。
      if (!empty($get_url_tag)) {
         // タグで絞り込んだメモを取得。
         $tag_relation = Tag::availableTagInMemo($get_url_tag)->first();
         $memos = $tag_relation->memos;
      } else {
         //全メモを取得。
         $memos = Memo::availableMemos()->get();
      }

      return $memos;
   }
}
