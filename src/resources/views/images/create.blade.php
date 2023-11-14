<x-app-layout>
   <section class="max-w-screen-lg mx-auto text-gray-600 overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         画像の登録
      </h1>
      <x-input-error :messages="$errors->get('files[][image]')" class="mt-2" />
      <x-input-error :messages="$errors->get('files')" class="mt-2" />
      <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
         @csrf
         <div class=" -m-2">
            {{-- 画像選択-------------------------------------------------------------------- --}}
            <div class="p-2 w-1/2 mx-auto">
               <div class="relative">
                  <label for="image" class="leading-7 text-sm text-gray-600">画像</label>

                  <input type="file" id="image" name="files[][image]" multiple
                     accept="image/ png,image/jpeg,image/jpg"
                     class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
               </div>
            </div>
         </div>

         {{-- ボタン -------------------------------------------------------------------------- --}}
         <div class="p-2 w-full flex justify-around mt-4">
            <button type="button" onclick="location.href='{{ route('image.index') }}'"
               class="py-2 px-8 bg-gray-200 border-0 hover:bg-gray-400 rounded text-lg">戻る
            </button>
            <button type="submit"
               class="py-2 px-8 text-white bg-indigo-500 border-0 hover:bg-indigo-600 rounded text-lg">登録
            </button>
         </div>
      </form>

   </section>
</x-app-layout>
