<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">
            {{ $subtitle }}
        </h6>
    </div>
    <ul class="list-group list-group-flush">
        {{-- this is for check a collection--}}
        @if (is_a($items, 'Illuminate\Support\Collection')) 
            @foreach ($items as $item)
                <li class="list-group-item">
                    {{ $item }}
                </li>
            @endforeach
        @else
        {{-- this is for not a collection --}}
            {{ $items }}
        @endif
    </ul>
</div>