<x-app-layout>
   <div class="mb-2 h-[30vh] flex justify-between">
      <section class="w-2/5 text-gray-600 border-gray-300 border rounded-lg overflow-hidden">
         <h1 class="px-3 py-2 border-b text-lg bg-gray-200 border-slate-300">
            タグ一覧
         </h1>
         <div class="p-3 h-full overflow-y-scroll overscroll-none">
            タグ一覧エリア
         </div>
      </section>
      <section class="w-3/5 ml-2 text-gray-600 border-gray-300 border rounded-lg overflow-hidden">
         <h1 class="px-3 py-2 border-b text-lg bg-gray-200 border-slate-300">
            メモ一覧
         </h1>
         <div class="p-3 h-full overflow-y-scroll overscroll-none">
            @foreach ($memos as $memo)
               <a href=""
                  class="block mb-2 truncate hover:font-semibold">{{ $memo->content }}</a>
            @endforeach
         </div>
      </section>
   </div>
   {{ $slot }}
</x-app-layout>
