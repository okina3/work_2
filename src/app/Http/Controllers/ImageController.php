<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Services\ImageService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //選択された画像を取得
        $image_files = $request->file('files');

        //もし、画像が選択されている場合、リサイズ。
        if (!is_null($image_files)) {
            foreach ($image_files as $image_file) {
                //画像をリサイズして、laravelのフォルダ内に保存。
                $only_one_file_name = ImageService::afterResizingImage($image_file);

                //リサイズした画像をデータベースに保存。
                Image::create([
                    'user_id' => Auth::id(),
                    'filename' => $only_one_file_name
                ]);
            }
        }

        return to_route('image.create')
            ->with([
                'message' => '画像を登録しました。',
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
