<div class="skeleton-loader {{ $type ?? 'text' }} {{ $class ?? '' }}">
    @if(isset($count) && $count > 1)
        @for($i = 0; $i < $count; $i++)
            <div class="skeleton-item"></div>
        @endfor
    @endif
</div>