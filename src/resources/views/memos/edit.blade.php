<x-common.index :tags="$tags" :memos="$memos">
   <section class="min-h-[45vh] text-gray-600 body-font overflow-hidden rounded-lg border border-gray-300">
      <h1 class="px-3 py-2 text-lg bg-gray-200 border-b border-slate-300">
         メモ編集
      </h1>
      <div class="p-3">
         <form action="{{ route('update', ['memo' => $edit_memo->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3">
               <textarea class="w-full rounded" name="content" rows="6" placeholder="ここにメモを入力">{{ $edit_memo->content }}</textarea>
               {{-- メモ内容のエラーメッセージ --}}
               <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            {{-- タグ一覧表示 --}}
            <div class="mb-5">
               @foreach ($tags as $t)
                  <div class="inline mr-3 hover:font-semibold">
                     <input type="checkbox" class="mb-1 rounded" name="tags[]" id="{{ $t->id }}"
                        value="{{ $t->id }}" {{ in_array($t->id, $memo_relation_tags) ? 'checked' : '' }} />
                     <label for="{{ $t->id }}">{{ $t->name }}</label>
                  </div>
               @endforeach
            </div>

            {{-- 新規タグ作成エリア --}}
            <div class="mb-10">
               <h1>新規タグの追加</h1>
               <div class="flex">
                  <div class="mr-5">
                     <input type="text" class="form-control rounded w-50" name="new_tag"
                        placeholder = "ここに新規タグを入力" />
                     {{-- 新規タグのエラーメッセージ --}}
                  </div>
                  <button type="submit"
                     class="text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-base">
                     更新
                  </button>
               </div>
               <x-input-error :messages="$errors->get('new_tag')" class="mt-2" />
            </div>
         </form>

         <div class="mt-3 mr-2 flex justify-end">
            {{-- メモの削除ボタン --}}
               <form action="{{ route('destroy', ['memo' => $edit_memo->id]) }}" method="POST">
                  @method('PUT')
                  @csrf
                  <button type="submit"
                     class="text-white bg-red-500 border-0 py-1 px-4 focus:outline-none hover:bg-red-600 rounded text-base">
                     メモを削除
                  </button>
               </form>
         </div>
      </div>
   </section>
</x-common.index>
