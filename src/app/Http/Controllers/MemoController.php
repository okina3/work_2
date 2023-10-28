<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMemoRequest;
use App\Models\Memo;
use App\Models\MemoTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query_tag = \Request::query('tag');

        //もしクエリパラメータtagがあれば、タグで絞り込み
        if (!empty($query_tag)) {
            //選択したクエリパラメータtagに紐づいたメモを取得する。
            $edit_memos = Tag::with('memos')
                ->where('user_id', Auth::id())
                ->where('id', $query_tag)
                ->whereNull('deleted_at')
                ->get();

            $memos = [];

            foreach ($edit_memos as $memo) {
                foreach ($memo->memos as $m) {
                    array_push($memos, $m);
                }
            }
        } else {
            //クエリパラメータtagがなければ、全メモを取得する。
            $memos = Memo::where('user_id', Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        //タグを取得する。
        $tags = Tag::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return view('create', compact('memos', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadMemoRequest $request)
    {
        //トライキャッチ構文
        try {
            DB::transaction(function () use ($request) {
                //メモを保存する。
                $memo_id = Memo::create([
                    'content' => $request->content,
                    'user_id' => Auth::id()
                ]);

                //タグが重複していないか、DBから調べる。
                $tag_exists = Tag::where('user_id', Auth::id())
                    ->where('name', $request->new_tag)
                    ->exists();

                //タグが入力してあり、DB内のタグが重複していないのなら、
                if (!empty($request->new_tag) && !$tag_exists) {
                    //タグを保存
                    $tag_id = Tag::create([
                        'name' => $request->new_tag,
                        'user_id' => Auth::id()
                    ]);
                    //中間テーブルに保存
                    MemoTag::create([
                        'memo_id' => $memo_id->id,
                        'tag_id' => $tag_id->id
                    ]);
                }

                //既存タグを新規メモに紐付ける
                if (!empty($request->tags)) {
                    foreach ($request->tags as $tag) {
                        MemoTag::create([
                            'memo_id' => $memo_id->id,
                            'tag_id' => $tag
                        ]);
                    }
                }
            }, 10);
            //エラー（例外）時の処理
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('index')
            ->with([
                'message' => 'メモを登録しました。',
                'status' => 'info'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //メモを一覧表示する
        $memos = Memo::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        //選択したメモを、編集エリアに表示する
        $edit_memo = Memo::find($id);

        //選択したメモに紐づいたタグを取得する。
        $edit_tags = Memo::with('tags')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->get();

        $include_tags = [];

        foreach ($edit_tags as $tag) {
            foreach ($tag->tags as $t) {
                array_push($include_tags, $t->id);
            }
        }

        //タグ一覧表示をする。
        $tags = Tag::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return view('edit', compact('memos', 'edit_memo', 'include_tags', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UploadMemoRequest $request, string $id)
    {
        //トライキャッチ構文
        try {
            DB::transaction(function () use ($request, $id) {
                //メモを更新
                $posts = Memo::findOrFail($id);
                $posts->content = $request->content;
                $posts->save();

                //一旦メモとタグを紐付けた中間デーブルのデータを削除
                MemoTag::where('memo_id', $id)->delete();

                //ここで再度中間テーブルにデータを入れる
                foreach ($request->tags as $tag) {
                    MemoTag::create([
                        'memo_id' => $posts->id,
                        'tag_id' => $tag
                    ]);
                }

                //新規タグの入力があった場合、タグが重複していないか、DBから調べる。
                $tag_exists = Tag::where('user_id', Auth::id())
                    ->where('name', $request->new_tag)
                    ->exists();

                //タグが入力してあり、DB内のタグが重複していないのなら、
                if (!empty($request->new_tag) && !$tag_exists) {
                    //タグを保存
                    $tag_id = Tag::create([
                        'name' => $request->new_tag,
                        'user_id' => Auth::id()
                    ]);

                    //中間テーブルに保存
                    MemoTag::create([
                        'memo_id' => $posts->id,
                        'tag_id' => $tag_id->id
                    ]);
                }
            }, 10);
            //エラー（例外）時の処理
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('index')
            ->with([
                'message' => 'メモを更新しました。',
                'status' => 'info'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Memo::findOrFail($id)->delete();

        return redirect()->route('index')
            ->with([
                'message' => 'メモを削除しました。',
                'status' => 'alert'
            ]);
    }
}
