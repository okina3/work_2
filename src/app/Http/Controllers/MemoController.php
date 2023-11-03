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
use Illuminate\View\View;
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
    public function index(): View
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

        //タグを取得する。
        $tags = Tag::availableTags()->get();

        return view('memos.create', compact('memos', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadMemoRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                //メモを保存。
                $memo = Memo::create([
                    'content' => $request->content,
                    'user_id' => Auth::id()
                ]);

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
            }, 10);
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
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
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

        return view('memos.edit', compact('memos', 'tags', 'edit_memo', 'memo_relation_tags'));
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
            }, 10);
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
