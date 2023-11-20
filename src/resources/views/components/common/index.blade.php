<x-app-layout>
    <div class="mb-2 h-[30vh] flex justify-between">
        <section class="w-1/3 text-gray-600 border border-gray-400 rounded-lg overflow-hidden">
            <h1 class="px-3 py-2 text-lg border-b border-slate-400 bg-gray-200">
                タグから検索
            </h1>
            <div class="p-3 h-[85%] overflow-y-scroll overscroll-none">
                <div class="mb-2 hover:font-semibold">
                    <a href="/">全て表示</a>
                </div>
                @foreach ($tags as $tag)
                    <a href="/?tag={{ $tag->id }}" class="mb-1 block truncate hover:font-semibold">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </section>
        <section class="ml-2 w-2/3 text-gray-600 border border-gray-400 rounded-lg overflow-hidden">
            <h1 class="px-3 py-2 text-lg border-b border-slate-400 bg-gray-200">
                メモ一覧
            </h1>
            <div class="p-3 h-[85%] overflow-y-scroll overscroll-none">
                @foreach ($memos as $memo)
                    <a href="{{ route('show', ['memo' => $memo->id]) }}"
                       class="mb-2 block truncate hover:font-semibold">{{ $memo->content }}</a>
                @endforeach
            </div>
        </section>
    </div>
    {{ $slot }}
</x-app-layout>
