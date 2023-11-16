<?php

namespace App\Services;

use App\Models\Memo;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
   /**
    * @param $image_file
    * @return string
    */
   //画像をリサイズして、laravelのフォルダ内に保存する。
   public static function afterResizingImage($image_file): string
   {
      //画像が１枚か、複数かで、記述の形式を変更する。
      if (is_array($image_file)) {
         $image_file_multiple_support = $image_file['image'];
      } else {
         $image_file_multiple_support = $image_file;
      }

      //ランダムなファイル名の生成
      $rnd_file_name = uniqid(rand() . '_');
      //選択画像の拡張子を取得。
      $get_extension = $image_file_multiple_support->extension();
      //ランダムなファイル名と、拡張子を合体させる。
      $only_one_file_name = $rnd_file_name . '.' . $get_extension;
      //実際のリサイズ
      $resize_image = InterventionImage::make($image_file_multiple_support)
         ->resize(720, 480)
         ->encode();

      //場所とファイル名を指定して、laravel内に保存する。
      Storage::put('public/' . $only_one_file_name, $resize_image);

      return $only_one_file_name;
   }


   /**
    * @param $image
    * @return void
    */
   //Storageフォルダ内画像ファイルを削除する。
   public static function storageDelete($image): void
   {
      //削除したい画像が、メモで使われているのか確認（ソフトデリートも含む）
      $image_in_memos = Memo::withTrashed()
         ->orWhere('image1', $image->id)
         ->orWhere('image2', $image->id)
         ->orWhere('image3', $image->id)
         ->orWhere('image4', $image->id)
         ->get();

      //使用していたら、どの画像を、どのメモで使っているのか調べ、値をnullに更新する。
      $image_in_memos?->each(function ($image_in_memo) use ($image) {
         if ($image_in_memo->image1 === $image->id) {
            $image_in_memo->image1 = null;
            $image_in_memo->save();
         }
         if ($image_in_memo->image2 === $image->id) {
            $image_in_memo->image2 = null;
            $image_in_memo->save();
         }
         if ($image_in_memo->image3 === $image->id) {
            $image_in_memo->image3 = null;
            $image_in_memo->save();
         }
         if ($image_in_memo->image4 === $image->id) {
            $image_in_memo->image4 = null;
            $image_in_memo->save();
         }
      });

      //Storageフォルダ内画像ファイルを削除。
      $file_path = 'public/' . $image->filename;
      if (Storage::exists($file_path)) {
         Storage::delete($file_path);
      }
   }
}
