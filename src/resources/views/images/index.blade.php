<x-app-layout>
   <section class="max-w-screen-lg mx-auto text-gray-600 body-font overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         登録画像一覧
      </h1>
      <div class="p-3">
         <x-common.flash-message status="session('status')" />
         <div class="mb-3 mr-1 flex justify-end">
            <button onclick="location.href='{{ route('image.create') }}'"
               class="py-2 px-4 text-white bg-indigo-500 border-0 focus:outline-none hover:bg-indigo-600 rounded text-base">
               画像新規登録
            </button>
         </div>

         {{-- 登録画像の一覧表示  --}}
         <div class="flex flex-wrap">
            @foreach ($images as $image)
               <div class="w-1/4 p-1">
                  <a href="{{ route('image.edit', ['image' => $image->id]) }}">
                     {{-- 画像 --}}
                     <img src="{{ asset('storage/' . $image->filename) }}" alt="画像が入ります">
                     {{-- タイトル --}}
                     <div class="text-x1">{{ $image->title }}</div>
                  </a>
               </div>
            @endforeach
         </div>
      </div>
   </section>
</x-app-layout>
