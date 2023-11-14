<x-app-layout>
   <section class="max-w-screen-lg mx-auto text-gray-600 overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         タグ一覧
      </h1>
      <div class="p-3">
         <x-common.flash-message status="session('status')" />
         {{-- 新規タグ作成エリア --}}
         <form action="{{ route('tag.store') }}" method="post">
            @csrf
            <div class="mb-10">
               <h1>新規タグ作成</h1>
               <div class="flex">
                  <div class="mr-5">
                     <input type="text" class="form-control rounded w-50" name="new_tag" placeholder = "ここに新規タグを入力" />
                  </div>
                  <button type="submit"
                     class="py-1 px-4 text-white bg-indigo-500 border-0 hover:bg-indigo-600 rounded text-lg">
                     保存
                  </button>
               </div>
               {{-- 新規タグのエラーメッセージ --}}
               <x-input-error :messages="$errors->get('new_tag')" class="mt-2" />
            </div>
         </form>

         {{-- タグ一覧 --}}
         <form action="{{ route('tag.destroy') }}" method="post">
            @method('put')
            @csrf
            <div class="mb-5">
               <h1>既存のタグ</h1>
               @foreach ($tags as $t)
                  <div class="inline mr-3 hover:font-semibold border-b border-slate-500">
                     <input type="checkbox" class="rounded mb-1" name="tags[]" id="{{ $t->id }}"
                        value="{{ $t->id }}" />
                     <label for="{{ $t->id }}">{{ $t->name }}</label>
                  </div>
               @endforeach
            </div>
            <div class="flex justify-end">
               <button type="submit" onclick="deletePost(this)"
                  class="py-1 px-4 text-white bg-red-500 border-0 hover:bg-red-600 rounded text-lg">
                  タグを削除
               </button>
            </div>
         </form>
      </div>
   </section>
   <script>
      function deletePost(e) {
         'use strict';
         if (!confirm('本当に削除してもいいですか?')) {
            return event.preventDefault();
         }
      }
   </script>
</x-app-layout>
