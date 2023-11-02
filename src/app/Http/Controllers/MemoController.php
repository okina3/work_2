<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMemoRequest;
use App\Models\Memo;
use App\Models\MemoTag;
use App\Models\Tag;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class MemoController extends Controller
{
    public function __construct()
    {
        //別のユーザーのメモを見れなくする認証。
        $this->middleware(function (Request $request, Closure $next) {
            $id_memo = $request->route()->parameter('memo');
            if (!is_null($id_memo)) {
                $memo_relation_user = Memo::findOrFail($id_memo)->user->id;
                if ($memo_relation_user !== Auth::id()) {
                    abort(404);
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //クエリパラメータを取得。
        $get_url_tag = \Request::query('tag');

        //もしクエリパラメータtagがあれば、タグで絞り込む。
        if (!empty($get_url_tag)) {
            // 選択したクエリパラメータtagに紐づいたメモを取得。
            $tag_relation = Tag::availableTagInMemo($get_url_tag)->first();
            $memos = $tag_relation->memos;
        } else {
            //クエリパラメータtagがなければ、全メモを取得する。
            $memos = Memo::availableMemos()->get();
        }

        //タグを取得する。
        $tags = Tag::availableTags()->get();

        return view('memo.create', compact('memos', 'tags'));
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
                //メモを保存。
                $memo = Memo::create([
                    'content' => $request->content,
                    'user_id' => Auth::id()
                ]);

                //既存タグが選択されていたら、メモに紐付け保存する。
                if (!empty($request->tags)) {
                    foreach ($request->tags as $tag_number) {
                        MemoTag::availableMemoTagCreate($memo, $tag_number);
                    }
                }

                //新規タグの入力があった場合,タグが重複していないか調べる。
                $tag_exists = Tag::availableTagExists($request)->exists();
                //タグが入力してあり、DB内のタグが重複していない時の処理。
                Tag::availableTagCreate($request, $memo, $tag_exists);
            }, 10);
            //エラー（例外）時の処理
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return to_route('index')
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
        //メモの一覧表示。
        $memos = Memo::availableMemos()->get();

        //タグの一覧表示。
        $tags = Tag::availableTags()->get();

        //選択したメモを、編集エリアに表示。
        $edit_memo = Memo::find($id);

        //選択したメモに紐づいたタグを取得。
        $memo_relation = Memo::availableMemoInTag($id)->first();
        $memo_relation_tags = [];
        foreach ($memo_relation->tags as $memo_relation_tag) {
            array_push($memo_relation_tags, $memo_relation_tag->id);
        }

        return view('memo.edit', compact('memos', 'tags', 'edit_memo', 'memo_relation_tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UploadMemoRequest $request, string $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                //メモを更新。
                $memo = Memo::findOrFail($id);
                $memo->content = $request->content;
                $memo->save();

                //一旦メモとタグを紐付けた中間デーブルのデータを削除。
                MemoTag::where('memo_id', $id)->delete();

                //既存タグが選択されていたら、メモに紐付け保存する。
                if (!empty($request->tags)) {
                    foreach ($request->tags as $tag_number) {
                        MemoTag::availableMemoTagCreate($memo, $tag_number);
                    }
                }

                //新規タグの入力があった場合,タグが重複していないか調べる。
                $tag_exists = Tag::availableTagExists($request)->exists();
                //タグが入力してあり、DB内のタグが重複していない時の処理。
                Tag::availableTagCreate($request, $memo, $tag_exists);
            }, 10);
            //エラー（例外）時の処理
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return to_route('index')
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

        return to_route('index')
            ->with([
                'message' => 'メモを削除しました。',
                'status' => 'alert'
            ]);
    }
}
