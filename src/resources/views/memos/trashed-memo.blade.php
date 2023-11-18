<x-app-layout>
   <section class="max-w-screen-lg mx-auto text-gray-600 overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         削除したメモ一覧
      </h1>
      <div class="p-3 ">
         <x-common.flash-message status="session('status')" />
         @foreach ($trashed_memos as $trashed_memo)
            <div class="py-3 flex justify-between items-center border-b border-slate-300">
               {{-- ソフトデリートされたメモ一覧 --}}
               <div class="mr-10 truncate">
                  {{ $trashed_memo->content }}
               </div>
               <div class="flex justify-between">
                  {{-- 元に戻すボタン --}}
                  <form action="{{ route('trashed-memo.undo', ['trashed' => $trashed_memo->id]) }}" method="post"
                     class="mr-3">
                     @csrf
                     @method('patch')
                     <button type="submit"
                        class="w-24 py-1 px-2 text-white bg-indigo-500 border-0 hover:bg-indigo-600 rounded text-lg">
                        戻す
                     </button>
                  </form>
                  {{-- 完全削除ボタン --}}
                  <form action="{{ route('trashed-memo.destroy', ['trashed' => $trashed_memo->id]) }}" method="post">
                     @csrf
                     @method('delete')
                     <button type="submit"
                        class="w-24 py-1 px-2 text-white bg-red-500 border-0 hover:bg-red-600 rounded text-lg">
                        完全削除
                     </button>
                  </form>
               </div>
            </div>
         @endforeach
      </div>
   </section>
</x-app-layout>
