<x-app-layout>
   <section class="max-w-screen-lg mx-auto text-gray-600 body-font overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         画像一覧
      </h1>
      <div class="p-3">
         <x-common.flash-message status="session('status')" />
         <button onclick="location.href=''"
            class="text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-base">
            画像新規登録
         </button>

         {{-- 登録画像の一覧表示  --}}

      </div>
   </section>
</x-app-layout>
