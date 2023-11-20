<x-app-layout>
    <section class="max-w-screen-lg mx-auto text-gray-600 border border-gray-400 rounded-lg overflow-hidden">
        <div class="px-3 py-2 flex justify-between items-center border-b border-gray-400 bg-gray-200">
            <h1 class="py-1 text-xl font-semibold">画像の登録</h1>
        </div>
        <x-input-error :messages="$errors->get('files[][image]')" class="mt-2"/>
        <x-input-error :messages="$errors->get('files')" class="mt-2"/>
        <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class=" -m-2">
                {{-- 画像選択-------------------------------------------------------------------- --}}
                <div class="p-2 w-1/2 mx-auto">
                    <div class="mt-2">
                        <label for="image" class="text-gray-600">画像</label>

                        <input type="file" id="image" name="files[][image]" multiple
                               accept="image/ png,image/jpeg,image/jpg"
                               class="py-1 px-3 w-full border border-gray-300 rounded bg-gray-100">
                    </div>
                </div>
            </div>
            {{-- ボタン -------------------------------------------------------------------------- --}}
            <div class="mt-4 p-2 w-full flex justify-around text-lg">
                <button type="button" onclick="location.href='{{ route('image.index') }}'"
                        class="py-1 px-8 text-white rounded bg-cyan-500 hover:bg-cyan-600">戻る
                </button>
                <button type="submit"
                        class="py-1 px-8 text-white rounded bg-indigo-500 hover:bg-indigo-600">登録
                </button>
            </div>
        </form>
    </section>
</x-app-layout>
