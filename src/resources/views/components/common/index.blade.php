<x-app-layout>
   <div class="mb-2 h-[30vh] flex justify-between">
      <section class="w-1/3 text-gray-600 border-gray-300 border rounded-lg overflow-hidden">
         <h1 class="px-3 py-2 border-b text-lg bg-gray-200 border-slate-300">
            タグから検索
         </h1>
         <div class="p-3 h-[85%] overflow-y-scroll overscroll-none">
            <div class="mb-2 hover:font-semibold">
               <a href="/">全て表示</a>
            </div>
            @foreach ($tags as $tag)
               <a href="/?tag={{ $tag->id }}" class="block mb-1 truncate hover:font-semibold">
                  {{ $tag->name }}
               </a>
            @endforeach
         </div>
      </section>
      <section class="w-2/3 ml-2 text-gray-600 border-gray-300 border rounded-lg overflow-hidden">
         <h1 class="px-3 py-2 border-b text-lg bg-gray-200 border-slate-300">
            メモ一覧
         </h1>
         <div class="p-3 h-[85%] overflow-y-scroll overscroll-none">
            @foreach ($memos as $memo)
               <a href="{{ route('show', ['memo' => $memo->id]) }}"
                  class="block mb-2 truncate hover:font-semibold">{{ $memo->content }}</a>
            @endforeach
         </div>
      </section>
   </div>
   {{ $slot }}
</x-app-layout>
