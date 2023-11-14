<x-app-layout>
   <section class="max-w-screen-lg mx-auto text-gray-600 overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         画像の編集
      </h1>
      <div class="p-3">
         <x-common.flash-message status="session('status')" />

         <form action="{{ route('image.update', ['image' => $edit_image->id]) }}" method="post">
            @csrf
            @method('put')
            <div class="p-2 w-1/2 mx-auto">
               {{-- 選択画像 --}}
               <div class="relative">
                  <img src="{{ asset('storage/' . $edit_image->filename) }}" alt="画像が入ります">
               </div>
               {{-- 登録画像のタイトル --}}
               <div class="relative">
                  <label for="title" class="leading-7 text-sm text-gray-600">画像タイトル</label>
                  <input type="text" id="title" name="title" value="{{ $edit_image->title }}"
                     class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
               </div>
               {{-- 更新ボタン --}}
               <div class="p-2 w-full flex justify-around mt-4">
                  <button type="button" onclick="location.href='{{ route('image.index') }}'"
                     class="py-2 px-4 bg-gray-300 hover:bg-gray-400 rounded text-lg">
                     戻る
                  </button>
                  <button type="submit" class="py-2 px-4 text-white bg-indigo-500 hover:bg-indigo-600 rounded text-lg">
                     更新
                  </button>
               </div>
            </div>
         </form>
         {{-- 画像の削除ボタン --}}
         <div class="mt-3 mr-2 flex justify-end">
            <form id="delete_{{ $edit_image->id }}" action="{{ route('image.destroy', ['image' => $edit_image->id]) }}"
               method="post">
               @method('put')
               @csrf
               <a href="#" data-id="{{ $edit_image->id }}" onclick="deletePost(this)"
                  class="py-2 px-4 text-white bg-red-500 hover:bg-red-600 rounded text-lg">画像を削除
               </a>
            </form>
         </div>
      </div>
   </section>
   <script>
      function deletePost(e) {
         'use strict';
         if (confirm('本当に削除してもいいですか?')) {
            document.getElementById('delete_' + e.dataset.id).submit();
         }
      }
   </script>
</x-app-layout>
