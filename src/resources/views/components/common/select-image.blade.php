{{-- 属性による値の受け取り --}}
@php
   if ($name === 'image1') {
       $modal = 'modal-1';
   }
   if ($name === 'image2') {
       $modal = 'modal-2';
   }
   if ($name === 'image3') {
       $modal = 'modal-3';
   }
   if ($name === 'image4') {
       $modal = 'modal-4';
   }
@endphp

{{-- モーダルウィンドウの記述 --}}
<div class="modal micromodal-slide" id="{{ $modal }}" aria-hidden="true">
   <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $modal }}-title">
         {{-- タイトル --}}
         <header class="modal__header">
            <h2 class="modal__title" id="{{ $modal }}-title">
               ファイルを選択してください
            </h2>
            <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
         </header>
         {{-- モーダルウィンドウの本文 --}}
         <main class="modal__content" id="{{ $modal }}-content">
            <div class="flex flex-wrap ">
               {{-- 画像とタイトルの一覧表示 --}}
               @foreach ($images as $image)
                  <div class="w-1/4 p-1">
                     <div class="border rounded-md p-2">
                        {{-- 画像 --}}
                        <img class="image" data-id="{{ $name }}_{{ $image->id }}"
                           data-file="{{ $image->filename }}" data-path="{{ asset('storage/') }}" data-micromodal-close
                           src="{{ asset('storage/' . $image->filename) }}" alt="">
                        {{-- 画像のタイトル --}}
                        {{-- <div class="text-gray-700">{{ $image->title }}</div> --}}
                     </div>
                  </div>
               @endforeach
            </div>
         </main>
         {{-- モーダルウィンドウを閉じるボタン --}}
         <footer class="modal__footer">
            <button type="button" class="modal__btn modal__btn-primary">Continue</button>
            <button type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close
            </button>
         </footer>
      </div>
   </div>
</div>

{{-- ブラウザでの表示 --}}
<div class="w-1/6 mr-4 mb-4">
   {{-- 選択した画層の表示 --}}
   <img id="{{ $name }}_thumbnail" src="" alt="">
   <div class="mt-2 text-center">
      <a class="p-2 border-gray-300 border rounded-md hover:font-semibold"
         data-micromodal-trigger="{{ $modal }}" href='javascript:'>選択してください
      </a>
   </div>
</div>
<input id="{{ $name }}_hidden" type="hidden" name="{{ $name }}" value="">
