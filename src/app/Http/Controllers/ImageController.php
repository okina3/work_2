<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Services\ImageService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ImageController extends Controller
{
    public function __construct()
    {
        //別のユーザーの画像を見れなくする認証。
        $this->middleware(function (Request $request, Closure $next) {
            $id_image = $request->route()->parameter('image');
            if (!is_null($id_image)) {
                $image_relation_user = Image::findOrFail($id_image)->user->id;
                if ($image_relation_user !== Auth::id()) {
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
        //全画像を取得する。
        $images = Image::availableImages()->paginate(20);

        return view('images.index', compact('images'));
    }


    /**
     * @return View
     */
    public function create(): View
    {
        return view('images.create');
    }


    /**
     * @param UploadImageRequest $request
     * @return RedirectResponse
     */
    public function store(UploadImageRequest $request): RedirectResponse
    {
        //選択された画像を取得
        $image_files = $request->file('files');

        //もし、画像が選択されている場合リサイズ。
        if (!is_null($image_files)) {
            foreach ($image_files as $image_file) {
                //画像をリサイズして、laravelのフォルダ内に保存。
                $only_one_file_name = ImageService::afterResizingImage($image_file);
                //リサイズした画像をDBに保存。
                Image::create([
                    'user_id' => Auth::id(),
                    'filename' => $only_one_file_name
                ]);
            }
        }

        return to_route('image.index')
            ->with([
                'message' => '画像を登録しました。',
                'status' => 'info'
            ]);
    }


    /**
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        //選択した画像を、編集エリアに表示。
        $edit_image = Image::findOrFail($id);

        return view('images.edit', compact('edit_image'));
    }


    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //画像の更新。
        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        return to_route('image.index')
            ->with([
                'message' => '画像を更新しました。',
                'status' => 'info'
            ]);
    }


    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        //削除したい画像を取得。
        $image = Image::findOrFail($id);

        //先に、Storageフォルダ内画像ファイルを削除。
        ImageService::storageDelete($image);

        //削除したい画像をDBから削除。
        Image::findOrFail($id)->delete();

        return to_route('image.index')
            ->with([
                'message' => '画像を削除しました。',
                'status' => 'alert'
            ]);
    }
}
