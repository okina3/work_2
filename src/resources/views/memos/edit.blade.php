<x-common.index :tags="$tags" :memos="$memos">
    <section class="min-h-[45vh] text-gray-600 border border-gray-400 rounded-lg overflow-hidden">
        <div class="px-3 py-2 flex justify-between items-center border-b border-gray-400 bg-gray-200">
            <h1 class="py-1 text-xl font-semibold">メモ編集</h1>
            <button onclick="location.href='{{ route('index') }}'"
                    class="py-1 px-5 text-white text-lg rounded bg-cyan-500 hover:bg-cyan-600">
                戻る
            </button>
        </div>
        <div class="p-3">
            <form action="{{ route('update', ['memo' => $edit_memo->id]) }}" method="post">
                @csrf
                @method('patch')
                {{-- 選択したメモの内容表示エリア --}}
                <div class="mb-3">
                    <textarea class="w-full rounded" name="content" rows="7"
                              placeholder="ここにメモを入力">{{ $edit_memo->content }}</textarea>
                    {{-- メモの内容エラーメッセージ --}}
                    <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                </div>

                {{-- 既存タグの選択エリア --}}
                <div class="mb-10">
                    <h1 class="mb-1">既存タグの選択</h1>
                    @foreach ($tags as $tag)
                        <div class="inline mr-3 hover:font-semibold">
                            <input type="checkbox" class="mb-1 rounded" name="tags[]" id="{{ $tag->id }}"
                                   value="{{ $tag->id }}" {{ in_array($tag->id, $memo_relation_tags) ? 'checked' : '' }} />
                            <label for="{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- 新規タグ入力エリア --}}
                <div class="mb-10">
                    <h1>新規タグの追加</h1>
                    <div class="flex">
                        <div class="mr-5">
                            <input type="text" class="w-50 rounded" name="new_tag"
                                   placeholder="ここに新規タグを入力"/>
                        </div>
                    </div>
                    {{-- 新規タグのエラーメッセージ --}}
                    <x-input-error :messages="$errors->get('new_tag')" class="mt-2"/>
                </div>
                {{-- 選択画像の表示 --}}
                <div class="mb-10">
                    <h1 class="mb-1">画像の選択</h1>
                    <div class="flex items-end">
                        <x-common.select-image name="image1" :images='$images' currentId="{{ $edit_memo->image1 }}"
                                               currentImage="{{ $edit_memo->imageFirst->filename ?? '' }}"
                                               currentTitle="{{ $edit_memo->imageFirst->title ?? '' }}"/>
                        <x-common.select-image name="image2" :images='$images' currentId="{{ $edit_memo->image2 }}"
                                               currentImage="{{ $edit_memo->imageSecond->filename ?? '' }}"
                                               currentTitle="{{ $edit_memo->imageSecond->title ?? '' }}"/>
                        <x-common.select-image name="image3" :images='$images' currentId="{{ $edit_memo->image3 }}"
                                               currentImage="{{ $edit_memo->imageThird->filename ?? '' }}"
                                               currentTitle="{{ $edit_memo->imageThird->title ?? '' }}"/>
                        <x-common.select-image name="image4" :images='$images' currentId="{{ $edit_memo->image4 }}"
                                               currentImage="{{ $edit_memo->imageFourth->filename ?? '' }}"
                                               currentTitle="{{ $edit_memo->imageFourth->title ?? '' }}"/>
                    </div>
                </div>
                <div class="mb-5">
                    <button type="submit"
                            class="py-1 px-4 text-white text-lg rounded bg-indigo-500 hover:bg-indigo-600">
                        メモを更新する
                    </button>
                </div>
            </form>

            {{-- メモの削除ボタン --}}
            <div class="mt-3 mr-2 flex justify-end">
                <form action="{{ route('destroy', ['memo' => $edit_memo->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit"
                            class="py-1 px-4 text-white text-lg rounded bg-red-500 hover:bg-red-600">
                        メモを削除
                    </button>
                </form>
            </div>
        </div>
    </section>
    <script>
        'use strict'
        //モーダルウィンド
        const IMAGES = document.querySelectorAll('.image')
        IMAGES.forEach(image => {
            image.addEventListener('click', function (e) {
                const IMAGE_NAME = e.target.dataset.id.substring(0, 6)
                const IMAGE_ID = e.target.dataset.id.replace(IMAGE_NAME + '_', '')
                const IMAGE_FILE = e.target.dataset.file
                const IMAGE_PATH = e.target.dataset.path
                //imgタグの、id = "_thumbnail"を指定。（ブラウザ用）
                document.getElementById(IMAGE_NAME + '_thumbnail').src = IMAGE_PATH + '/' + IMAGE_FILE
                //inputタグのid="_hidden"を指定。（DB用）
                document.getElementById(IMAGE_NAME + '_hidden').value = IMAGE_ID
            })
        })
    </script>
</x-common.index>
