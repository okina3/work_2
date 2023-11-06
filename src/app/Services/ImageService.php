<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
   //画像をリサイズして、laravelのフォルダ内に保存する。
   public static function afterResizingImage($image_file)
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
}
