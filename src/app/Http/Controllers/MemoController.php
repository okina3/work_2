<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMemoRequest;
use App\Models\Image;
use App\Models\Memo;
use App\Models\MemoTag;
use App\Models\Tag;
use App\Services\MemoService;
use App\Services\TagService;
use Closure;
use Illuminate\Http\RedirectResponse;
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
     * @return View
     */
    public function index(): View
    {
        //全メモ、また、検索したメモを表示する。
        $memos = MemoService::memoSearchAll();
        //全タグを取得する。
        $tags = Tag::availableTags()->get();
        //全画像を取得する。
        $images = Image::availableImages()->get();

        return view('memos.create', compact('memos', 'tags', 'images'));
    }


    /**
     * @param UploadMemoRequest $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(UploadMemoRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                //メモを保存。
                $memo = Memo::create([
                    'content' => $request->content,
                    'user_id' => Auth::id(),
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                ]);
                //新規タグ、既存タグの保存。
                TagService::tagCreate($request, $memo);
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
    public function show(string $id)
    {
        //メモの一覧表示。
        $memos = Memo::availableMemos()->get();
        //タグの一覧表示。
        $tags = Tag::availableTags()->get();
        //選択したメモを、編集エリアに表示。
        $show_memo = Memo::findOrFail($id);
        //選択したメモに紐づいたタグを取得。
        $memo_relation_tags = TagService::memoRelationTags($id);

        return view('memos.show', compact('memos', 'tags', 'show_memo', 'memo_relation_tags'));
    }


    /**
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        //メモの一覧表示。
        $memos = Memo::availableMemos()->get();
        //タグの一覧表示。
        $tags = Tag::availableTags()->get();
        //選択したメモを、編集エリアに表示。
        $edit_memo = Memo::findOrFail($id);
        //選択したメモに紐づいたタグを取得。
        $memo_relation_tags = TagService::memoRelationTags($id);
        //全画像を取得する。
        $images = Image::availableImages()->get();

        return view('memos.edit', compact('memos', 'tags', 'edit_memo', 'memo_relation_tags', 'images'));
    }


    /**
     * @param UploadMemoRequest $request
     * @param string $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UploadMemoRequest $request, string $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $id) {
                //メモを更新。
                $memo = Memo::findOrFail($id);
                $memo->content = $request->content;
                $memo->image1 = $request->image1;
                $memo->image2 = $request->image2;
                $memo->image3 = $request->image3;
                $memo->image4 = $request->image4;
                $memo->save();
                //一旦メモとタグを紐付けた中間デーブルのデータを削除。
                MemoTag::where('memo_id', $id)->delete();
                //新規タグ、既存タグの更新。
                TagService::tagCreate($request, $memo);
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
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        Memo::findOrFail($id)->delete();

        return to_route('index')
            ->with([
                'message' => 'メモを削除しました。',
                'status' => 'alert'
            ]);
    }
}
