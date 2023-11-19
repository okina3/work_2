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

   $c_id = $currentId ?? '';
   $c_image = $currentImage ?? '';
   $c_title = $currentTitle ?? '';
@endphp

{{-- モーダルウィンドウ --}}
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
         {{-- モーダルウィンドウの画像 --}}
         <main class="modal__content" id="{{ $modal }}-content">
            <div class="flex flex-wrap ">
               @foreach ($images as $image)
                  <div class="w-1/4 p-1">
                     <div class="border rounded-md p-2">
                        <img class="image" data-id="{{ $name }}_{{ $image->id }}"
                           data-file="{{ $image->filename }}" data-path="{{ asset('storage/') }}" data-micromodal-close
                           src="{{ asset('storage/' . $image->filename) }}" alt="">
                        {{-- 画像のタイトル --}}
                        <div class="text-gray-700 text-center">{{ $image->title }}</div>
                     </div>
                  </div>
               @endforeach
            </div>
         </main>
      </div>
   </div>
</div>

{{-- ブラウザの表示 --}}
<div class="w-1/6 mr-4 mb-4">
   {{-- getElementByIdで指定。（選択画像のブラウザへの表示） --}}
   <img id="{{ $name }}_thumbnail"
      @if ($c_image) src="{{ asset('storage/' . $c_image) }}" @else src="" @endif alt="">
   <div class="text-center">
      <div class="h-8 mx-2 font-semibold truncate">{{ $c_title }}</div>
      <a class="p-2 border-gray-300 border rounded-md hover:font-semibold"
         data-micromodal-trigger="{{ $modal }}" href='javascript:'>選択してください
      </a>
   </div>
</div>
{{-- getElementByIdで指定。（DBに渡す選択画像のidのデータ） --}}
<input id="{{ $name }}_hidden" type="hidden" name="{{ $name }}" value="{{ $c_id }}">
