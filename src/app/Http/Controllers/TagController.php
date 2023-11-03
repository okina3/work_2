<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadTagRequest;
use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TagController extends Controller
{
   public function index(Request $request): View
   {
      //タグを取得する。
      $tags = Tag::availableTags()->get();

      return view('tags.index', compact('tags'));
   }


   public function store(UploadTagRequest $request)
   {
      //タグが重複していないか調べる。
      $tag_exists = Tag::availableTagExists($request)->exists();

      //タグが、重複していなれば、タグを保存。
      if (!empty($request->new_tag) && !$tag_exists) {
         Tag::create([
            'name' => $request->new_tag,
            'user_id' => Auth::id()
         ]);
      } 

      return to_route('tag.index')
         ->with([
            'message' => 'タグを登録しました。',
            'status' => 'info'
         ]);
   }


   public function destroy(Request $request)
   {
      //タグを複数まとめて削除。
      foreach ($request->tags as $tag) {
         Tag::findOrFail($tag)->delete();
      }

      return to_route('tag.index')
         ->with([
            'message' => 'タグを削除しました。',
            'status' => 'alert'
         ]);
   }
}
