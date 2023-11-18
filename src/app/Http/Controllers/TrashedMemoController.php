<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TrashedMemoController extends Controller
{
    /**
     * @return View
     */
    //ソフトデリートしたメモ一覧。
    public function trashedMemoIndex(): View
    {
        $trashed_memos = Memo::onlyTrashed()
            ->where('user_id', Auth::id())
            ->get();

        return view('memos.trashed-memo', compact('trashed_memos'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    //ソフトデリートしたメモを元に戻す。
    public function trashedMemoUndo($id): RedirectResponse
    {
        Memo::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->restore();

        return to_route('trashed-memo.index')
            ->with([
                'message' => 'メモを元に戻しました。',
                'status' => 'info'
            ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    //ソフトデリートしたメモの完全削除。
    public function trashedMemoDestroy($id): RedirectResponse
    {
        Memo::onlyTrashed()
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->forceDelete();

        return to_route('trashed-memo.index')
            ->with([
                'message' => 'メモを完全に削除しました。',
                'status' => 'alert'
            ]);
    }
}
