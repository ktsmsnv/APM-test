@extends('layouts.app')
@section('title')
    {{ "APM | КСТ | Карты проекта" }}
@endsection
@section('content')
    <div class="container">
        <div class="d-flex gap-4 align-items-center mb-2">
            <h1>Карты проекта</h1>
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
        <a href="{{ route('project-create') }}" class="btn btn-primary btn-lg mb-4">Добавить карту</a>
        <div id="resultsContainer"> <!-- Этот блок будет содержать результаты поиска -->
            @if (count($data) > 0)
                @foreach ($data as $el)
                    <div class="alert alert-info">
                        <h3>{{ $el->projNum }}</h3>
                        <p>{{ $el->projManager }}</p>
                        <p><small>{{ $el->objectName }}</small></p>
                        <a href="{{ route('project-data-one', ['id' => $el->id, 'tab' => '#calculation']) }}"><button
                                class="btn btn-outline-primary">Детальнее</button></a>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {!! $data->links() !!}
                </div>
            @else
                <h4 style="color: white;">Нет карт проекта</h4>
            @endif
        </div>

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
                    success: function(response) {
                        $("#resultsContainer").html(
                        response); // Обновляем контейнер с результатами поиска
                    },
                    error: function(error) {

                    }
                });
            });

            // Перехватываем клик на пагинацию
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                var page = $(this).attr('href').split('page=')[1]; // Получаем номер страницы
                var searchText = $("#searchInput").val();

                $.ajax({
                    url: "{{ route('search-projects') }}",
                    type: "GET",
                    data: {
                        page: page, // Передаем номер страницы
                        search: searchText // Передаем текст поиска
                    },
                    success: function(response) {
                        $("#resultsContainer").html(
                        response); // Обновляем контейнер с результатами поиска
                    },
                    error: function(error) {

                    }
                });
            });
        });
    </script>
@endsection
