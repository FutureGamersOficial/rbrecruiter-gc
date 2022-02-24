@if (!empty($link))
    <a href="{{ $link }}" target="{{ $target ?? '' }}">
        <button {{ ($disabled == true) ? 'disabled' : ''}} type="{{ $type }}" class="btn {{ !empty($size) ? 'btn-' . $size : '' }} btn-{{ $color }}" id="{{ $id }}">
            @if (empty($icon))
                {{ $slot }}
            @else
                <i class="{{ $icon }}"></i> {{ $slot }}
            @endif
        </button>
    </a>
@else
    <button {{ ($disabled == true) ? 'disabled' : ''}} type="{{ $type }}" class="ml-2 btn {{ !empty($size) ? 'btn-' . $size : '' }} btn-{{ $color }}" id="{{ $id }}">
        @if (empty($icon))
            {{ $slot }}
        @else
            <i class="{{ $icon }}"></i> {{ $slot }}
        @endif
    </button>
@endif
