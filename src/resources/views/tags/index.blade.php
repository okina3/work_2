<x-app-layout>
    <section class="max-w-screen-lg mx-auto text-gray-600 border border-gray-400 rounded-lg overflow-hidden">
        <div class="px-3 py-2 flex justify-between items-center border-b border-gray-400 bg-gray-200">
            <h1 class="py-1 text-xl font-semibold">タグ一覧</h1>
        </div>
        <div class="p-3">
            <x-common.flash-message status="session('status')"/>
            {{-- 新規タグ作成エリア --}}
            <form action="{{ route('tag.store') }}" method="post">
                @csrf
                <div class="mb-10">
                    <h1>新規タグ作成</h1>
                    <div class="flex">
                        <div class="mr-5">
                            <input type="text" class="form-control rounded w-50" name="new_tag"
                                   placeholder="ここに新規タグを入力"/>
                        </div>
                        <button type="submit"
                                class="py-1 px-4 text-lg text-white border-0 rounded bg-indigo-500 hover:bg-indigo-600">
                            保存
                        </button>
                    </div>
                    {{-- 新規タグのエラーメッセージ --}}
                    <x-input-error :messages="$errors->get('new_tag')" class="mt-2"/>
                </div>
            </form>

            {{-- タグ一覧 --}}
            <form onsubmit="return deleteCheck()" action="{{ route('tag.destroy') }}" method="post">
                @csrf
                @method('delete')
                <div class="mb-5">
                    <h1>既存のタグ</h1>
                    @foreach ($tags as $t)
                        <div class="inline mr-3 border-b border-slate-500">
                            <input type="checkbox" class="mb-1 rounded" name="tags[]" id="{{ $t->id }}"
                                   value="{{ $t->id }}" disabled/>
                            <label for="{{ $t->id }}">{{ $t->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                            class="py-1 px-4 text-lg text-white border-0 rounded bg-red-500 hover:bg-red-600">
                        タグを削除
                    </button>
                </div>
            </form>
        </div>
    </section>
    <script>
        'use strict'

        //削除のアラート
        function deleteCheck() {
            const RESULT = confirm('本当に削除してもいいですか?');
            if (!RESULT) alert("削除をキャンセルしました");
            return RESULT;
        }
    </script>
</x-app-layout>
