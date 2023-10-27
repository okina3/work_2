<x-common.index :tags="$tags" :memos="$memos">
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

            {{-- タグ一覧 --}}
            <div class="mb-5">
               {{-- <h1>タグ一覧</h1> --}}
               @foreach ($tags as $t)
                  <div class="inline mr-3 hover:font-semibold">
                     <input type="checkbox" class="rounded mb-1" name="tags[]" id="{{ $t->id }}"
                        value="{{ $t->id }}" />
                     <label class="" for="{{ $t->id }}">{{ $t->name }}</label>
                  </div>
               @endforeach
            </div>

            {{-- 新規タグ作成エリア --}}
            <div class="mb-3">
               <h1>新規タグ作成</h1>
               <input type="text" class="form-control rounded w-50 mb-3" name="new_tag" placeholder = "ここに新規タグを入力" />
            </div>

            <button type="submit"
               class="text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-base">
               保存
            </button>
         </form>
      </div>
   </section>
</x-common.index>
