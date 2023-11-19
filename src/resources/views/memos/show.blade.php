<x-common.index :tags="$tags" :memos="$memos">
    <section class="min-h-[45vh] text-gray-600 body-font overflow-hidden rounded-lg border border-gray-300">
        <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-gray-300">
            メモ詳細
        </h1>
        <div class="p-3">
            <div class="mb-5">
                {{-- メモ内容の表示エリア --}}
                <h1 class="mb-1 text-lg">本文</h1>
                <textarea class="w-full rounded" name="content" rows="7"
                          placeholder="ここにメモを入力" disabled>{{ $show_memo->content }}</textarea>
            </div>

            {{-- 既存タグの表示エリア --}}
            <div class="mb-10">
                <h1 class="mb-1 text-lg">タグ</h1>
                @foreach ($tags as $tag)
                    <div class="inline mr-3">
                        <input type="checkbox" class="mb-1 rounded" name="tags[]" id="{{ $tag->id }}"
                               value="{{ $tag->id }}"
                               {{ in_array($tag->id, $memo_relation_tags) ? 'checked' : '' }} disabled/>
                        <label for="{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>

            {{-- 選択画像の表示 --}}
            <div class="mb-10">
                <h1 class="mb-1 text-lg">画像</h1>
                <div class="flex">
                    <x-common.show-select-image currentId="{{ $show_memo->image1 }}"
                                                currentImage="{{ $show_memo->imageFirst->filename ?? '' }}"
                                                currentTitle="{{ $show_memo->imageFirst->title ?? '' }}" name="image1"/>
                    <x-common.show-select-image currentId="{{ $show_memo->image2 }}"
                                                currentImage="{{ $show_memo->imageSecond->filename ?? '' }}"
                                                currentTitle="{{ $show_memo->imageSecond->title ?? '' }}"
                                                name="image2"/>
                    <x-common.show-select-image currentId="{{ $show_memo->image3 }}"
                                                currentImage="{{ $show_memo->imageThird->filename ?? '' }}"
                                                currentTitle="{{ $show_memo->imageThird->title ?? '' }}" name="image3"/>
                    <x-common.show-select-image currentId="{{ $show_memo->image4 }}"
                                                currentImage="{{ $show_memo->imageFourth->filename ?? '' }}"
                                                currentTitle="{{ $show_memo->imageFourth->title ?? '' }}"
                                                name="image4"/>
                </div>
            </div>
            <div class="flex">
                <button onclick="location.href='{{ route('index') }}'"
                        class="mr-5 py-1 px-5 text-white bg-cyan-500 hover:bg-cyan-600 rounded text-lg">
                    戻る
                </button>
                <button onclick="location.href='{{ route('edit', ['memo' => $show_memo->id]) }}'"
                        class="py-1 px-4 text-white bg-indigo-500 hover:bg-indigo-600 rounded text-lg">
                    編集する
                </button>

            </div>
        </div>
    </section>
</x-common.index>
