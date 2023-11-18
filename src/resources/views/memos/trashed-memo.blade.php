<x-app-layout>
   <section class="max-w-screen-lg mx-auto text-gray-600 overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         削除したメモ一覧
      </h1>
      <div class="p-3">
         <x-common.flash-message status="session('status')" />
         {{-- ソフトデリートされたメモ一覧 --}}
         @foreach ($trashed_memos as $trashed_memo)
            <form onsubmit="return deleteCheck()"
               action="{{ route('trashed-memo.destroy', ['trashed' => $trashed_memo->id]) }}" method="post">
               @csrf
               @method('delete')
               <div class="py-3 flex justify-between items-center border-b border-slate-300">
                  <div class="w-2/3 truncate">
                     {{ $trashed_memo->content }}
                  </div>
                  <button type="submit"
                     class="py-1 px-4 text-white bg-red-500 border-0 hover:bg-red-600 rounded text-lg">
                     完全削除
                  </button>
               </div>
         @endforeach
         </form>
      </div>
   </section>
   <script>
      'use strict'
      //削除のアラート
      function deleteCheck() {
         const RESULT = confirm('本当に削除してもいいですか?');
         if (!RESULT) alert("削除をキャンセルしました");
         return RESULT;
      }
   </script>
</x-app-layout>
