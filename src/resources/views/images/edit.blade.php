<x-app-layout>
    <section class="max-w-screen-lg mx-auto text-gray-600 border border-gray-400 rounded-lg overflow-hidden">
        <div class="px-3 py-2 flex justify-between items-center border-b border-gray-400 bg-gray-200">
            <h1 class="py-1 text-xl font-semibold">画像の編集</h1>
        </div>
        <div class="p-3">
            <x-common.flash-message status="session('status')"/>
            <form action="{{ route('image.update', ['image' => $edit_image->id]) }}" method="post">
                @csrf
                @method('patch')
                <div class="p-2 w-1/2 mx-auto">
                    {{-- 選択画像 --}}
                    <div class="relative">
                        <img src="{{ asset('storage/' . $edit_image->filename) }}" alt="画像が入ります">
                    </div>
                    {{-- 登録画像のタイトル --}}
                    <div class="mt-2">
                        <label for="title" class="text-gray-600">画像タイトル</label>
                        <input type="text" id="title" name="title" value="{{ $edit_image->title }}"
                               class="w-full border border-gray-300 rounded bg-gray-100">
                    </div>
                    {{-- 更新ボタン --}}
                    <div class="mt-4 w-full flex justify-around text-lg">
                        <button type="button" onclick="location.href='{{ route('image.index') }}'"
                                class="py-1.5 px-4 text-white rounded bg-cyan-500 hover:bg-cyan-600">
                            戻る
                        </button>
                        <button type="submit"
                                class="py-1.5 px-4 text-white rounded bg-indigo-500 hover:bg-indigo-600">
                            更新
                        </button>
                    </div>
                </div>
            </form>
            {{-- 画像の削除ボタン --}}
            <div class="mt-3 mr-2 flex justify-end">
                <form onsubmit="return deleteCheck()"
                      action="{{ route('image.destroy', ['image' => $edit_image->id]) }}"
                      method="post">
                    @csrf
                    @method('delete')
                    <button type="submit"
                            class="py-1 px-4 text-lg text-white rounded bg-red-500 hover:bg-red-600">
                        画像を削除
                    </button>
                </form>
            </div>
        </div>
    </section>
    <script>
        'use strict';

        //削除のアラート
        function deleteCheck() {
            const RESULT = confirm('本当に削除してもいいですか?');
            if (!RESULT) alert("削除をキャンセルしました");
            return RESULT;
        }
    </script>
</x-app-layout>
