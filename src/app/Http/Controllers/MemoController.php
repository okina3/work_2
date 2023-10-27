<?php

namespace App\Http\Controllers;

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
        //メモを一覧表示する
        $memos = Memo::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        //タグを取得する。
        $tags = Tag::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return view('create', compact('memos','tags'));
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
    public function store(Request $request)
    {
        //バリデーションがない
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
                    // dd('既存タグを選択しているぞ');
                    foreach ($request->tags as $tag) {
                        // MemoTag::insert(['memo_id' => $memo_id, 'tag_id' => $tag]);
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
            ->route('home')
            ->with('message', 'メモを登録しました。');
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
        //メモを取得する（一覧表示用）
        $memos = Memo::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        //選択したメモを、編集エリアに表示する。
        $edit_memo = Memo::find($id);

        return view('edit', compact('memos', 'edit_memo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //更新したいメモを取得
        $posts = Memo::findOrFail($id);

        $posts->content = $request->content;
        $posts->save();

        return redirect()
            ->route('home')
            ->with('message', 'メモを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Memo::findOrFail($id)->delete();

        return redirect()->route('home')
            ->with('message', 'メモを削除しました。');
    }
}
