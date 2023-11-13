<x-common.index :tags="$tags" :memos="$memos">
   <section class="min-h-[45vh] text-gray-600 body-font overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-gray-300">
         新規メモ作成
      </h1>
      <div class="p-3">
         <x-common.flash-message status="session('status')" />
         <form action="{{ route('store') }}" method="POST">
            @csrf
            <div class="mb-3">
               <textarea class="w-full rounded" name="content" rows="6" placeholder="ここにメモを入力"></textarea>
               {{-- メモ内容のエラーメッセージ --}}
               <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            {{-- 既存タグの選択エリア --}}
            <div class="mb-5">
               <h1 class="mb-1">既存タグの選択</h1>
               @foreach ($tags as $t)
                  <div class="inline mr-3 hover:font-semibold">
                     <input type="checkbox" class="rounded mb-1" name="tags[]" id="{{ $t->id }}"
                        value="{{ $t->id }}" />
                     <label for="{{ $t->id }}">{{ $t->name }}</label>
                  </div>
               @endforeach
            </div>

            {{-- 新規タグ作成エリア --}}
            <div class="mb-5">
               <h1>新規タグの追加</h1>
               <div class="flex">
                  <div class="mr-5">
                     <input type="text" class="form-control rounded w-50" name="new_tag"
                        placeholder = "ここに新規タグを入力" />
                  </div>
               </div>
               {{-- 新規タグのエラーメッセージ --}}
               <x-input-error :messages="$errors->get('new_tag')" class="mt-2" />
            </div>

            {{-- 選択画像の表示 --}}
            <div class="mb-5">
               <h1 class="mb-1">画像の選択</h1>
               <div class="flex items-end">
                  <x-common.select-image :images='$images' name="image1" />
                  <x-common.select-image :images='$images' name="image2" />
                  <x-common.select-image :images='$images' name="image3" />
                  <x-common.select-image :images='$images' name="image4" />
               </div>
            </div>
            <div class="mb-5">
               <button type="submit"
                  class="text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-base">
                  メモを保存する
               </button>
            </div>
         </form>
      </div>
   </section>
   <script>
      'use strict'
      const IMAGES = document.querySelectorAll('.image')
      IMAGES.forEach(image => {
         image.addEventListener('click', function(e) {
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
