@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex gap-4 align-items-center mb-4">
            <h1>Все карты проекта</h1>
            <form method="get" action="{{ route('search-projects') }}">
                <div class="search">
                    <label>
                        <input itype="text" name="search" id="searchInput"
                            placeholder="Поиск по номеру проекта, руководителю и объекту">
                        <ion-icon name="search-outline" role="img" class="md hydrated"></ion-icon>
                    </label>
                </div>
            </form>
        </div>
        <div id="resultsContainer"> <!-- Этот блок будет содержать результаты поиска -->
            @if(count($data) > 0)
            @foreach ($data as $el)
                <div class="alert alert-info">
                    <h3>{{ $el->projNum }}</h3>
                    <p>{{ $el->projManager }}</p>
                    <p><small>{{ $el->objectName }}</small></p>
                    <a href="{{ route('project-data-one', ['id' => $el->id, 'tab' => '#calculation']) }}"><button class="btn btn-outline-primary">Детальнее</button></a>
                </div>
            @endforeach
        @else
            <p>Нет карт проекта.</p>
        @endif
        </div>
        <a href="{{ route('project-create') }}" class="btn btn-primary  btn-lg">Добавить карту</a>
    </div>

    <script>
        $(document).ready(function() {
            $("#searchInput").on("input", function() {
                var searchText = $(this).val();
                $.ajax({
                    url: "{{ route('search-projects') }}",
                    type: "GET",
                    data: {
                        search: searchText
                    },
                    success: function(data) {
                        $("#resultsContainer").html(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
