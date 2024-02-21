@if (isset($noResults) && $noResults)
    <p class="nothing">Нет соответствующих записей</p>
@else
    @foreach ($data as $el)
        <div class="alert alert-info">
            <h3>{{ $el->projNum }}</h3>
            <p>{{ $el->projManager }}</p>
            <p><small>{{ $el->objectName }}</small></p>
            <a href="{{ route('project-data-one', $el->id) }}"><button class="btn btn-outline-primary">Детальнее</button></a>
        </div>
    @endforeach

@endif
