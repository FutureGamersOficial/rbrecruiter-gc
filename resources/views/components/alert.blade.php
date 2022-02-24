<div class="alert alert-{{$alertType}} {{$extraStyling ?? ''}}">

    @if (!empty($title))
        <p class="text-bold">@if (!empty($icon))<i class="fas {{ $icon }}"></i>  @endif {{ $title }}</p>
    @endif

    {{$slot}}
</div>
