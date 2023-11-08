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
                     {{-- 新規タグのエラーメッセージ --}}
                  </div>
               </div>
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
      const images = document.querySelectorAll('.image')
      images.forEach(image => { // 1つずつ繰り返す
         image.addEventListener('click', function(e) { // クリックしたら
            const imageName = e.target.dataset.id.substr(0, 6) //data-idの6文字
            const imageId = e.target.dataset.id.replace(imageName + '_', '') // 6文字カット
            const imageFile = e.target.dataset.file
            const imagePath = e.target.dataset.path
            const modal = e.target.dataset.modal
            // サムネイルと input type=hiddenのvalueに設定
            document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
            document.getElementById(imageName + '_hidden').value = imageId
         })
      })
   </script>
</x-common.index>
