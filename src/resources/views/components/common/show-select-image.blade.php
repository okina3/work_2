{{-- 属性による値の受け取り --}}
@php
    if ($name === 'image1') {
        $modal = 'modal-1';
    }
    if ($name === 'image2') {
        $modal = 'modal-2';
    }
    if ($name === 'image3') {
        $modal = 'modal-3';
    }
    if ($name === 'image4') {
        $modal = 'modal-4';
    }

    $c_id = $currentId ?? '';
    $c_image = $currentImage ?? '';
    $c_title = $currentTitle ?? '';
@endphp

{{-- 拡大画像、モーダルウィンドウ --}}
<div class="modal micromodal-slide" id="{{ $modal }}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $modal }}-title">
            <main class="modal__content" id="{{ $modal }}-content">
                <img src="{{ asset('storage/' . $c_image) }}" alt="">
                <div class="mt-3 text-xl font-semibold text-center">{{ $c_title }}</div>
            </main>
        </div>
    </div>
</div>

{{-- ブラウザのサムネイル画像 --}}
<div class="mr-4 mb-4 w-1/6">
    <a data-micromodal-trigger="{{ $modal }}" href='javascript:'>
        <img @if ($c_image) src="{{ asset('storage/' . $c_image) }}" @else src="" @endif
        alt="">
        <div class="mx-2 mt-1 font-semibold text-center truncate">{{ $c_title }}</div>
    </a>
</div>
