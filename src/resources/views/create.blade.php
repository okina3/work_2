<x-common.index :memos="$memos">
   <section class="min-h-[45vh] text-gray-600 body-font overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         新規メモ作成
      </h1>
      <div class="p-3">
         <form action="{{ route('store') }}" method="POST">
            @csrf
            <div class="mb-3">
               <textarea class="w-full rounded" name="content" rows="6" placeholder="ここにメモを入力"></textarea>
            </div>
            <button type="submit"
               class="text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-base">
               保存
            </button>
         </form>
      </div>
   </section>
</x-common.index>
