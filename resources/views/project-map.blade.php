@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-18">
                <h1 class="mb-5">Карта проекта Вн. Номер: {{ $project->projNum }}</h1>
                <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-calculation-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-calculation" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Расчет</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-realization-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-realization" type="button" role="tab"
                            aria-controls="pills-realization" aria-selected="false">Реализация</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-risks-tab" data-bs-toggle="pill" data-bs-target="#pills-risks"
                            type="button" role="tab" aria-controls="pills-risks" aria-selected="false">Риски</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-changes-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-changes" type="button" role="tab" aria-controls="pills-changes"
                            aria-selected="false">Изменения</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-report-tab" data-bs-toggle="pill" data-bs-target="#pills-report"
                            type="button" role="tab" aria-controls="pills-report" aria-selected="false">Отчет</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-smk-tab" data-bs-toggle="pill" data-bs-target="#pills-smk"
                            type="button" role="tab" aria-controls="pills-smk" aria-selected="false">СМК</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-diary-tab" data-bs-toggle="pill" data-bs-target="#pills-diary"
                            type="button" role="tab" aria-controls="pills-diary" aria-selected="false">Дневник
                            проекта</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    {{-- Расчет --}}
                    <div class="tab-pane fade show active" id="pills-calculation" role="tabpanel"
                        aria-labelledby="pills-calculation-tab">
                        @include('tables.calculation-projectMap')
                    </div>
                    {{-- Реализация --}}
                    <div class="tab-pane fade" id="pills-realization" role="tabpanel"
                        aria-labelledby="pills-realization-tab">
                        @include('tables.realization-projectMap')
                    </div>
                    {{-- Риски --}}
                    <div class="tab-pane fade" id="pills-risks" role="tabpanel" aria-labelledby="pills-risks-tab">
                        @include('tables.risks-projectMap')
                    </div>
                    {{-- Изменения --}}
                    <div class="tab-pane fade" id="pills-changes" role="tabpanel" aria-labelledby="pills-changes-tab">
                        @include('tables.changes-projectMap')
                    </div>
                    {{-- Отчет --}}
                    <div class="tab-pane fade" id="pills-report" role="tabpanel" aria-labelledby="pills-report-tab">
                        @include('tables.report-projectMap')
                    </div>
                    {{-- СМК --}}
                    <div class="tab-pane fade" id="pills-smk" role="tabpanel" aria-labelledby="pills-smk-tab">СМК</div>
                    {{-- Дневник --}}
                    <div class="tab-pane fade" id="pills-diary" role="tabpanel" aria-labelledby="pills-diary-tab">
                        @include('tables.notes-panel')
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            new DataTable('.projMap', {
                responsive: true,
                searching: false, // Отключаем поиск
                lengthMenu: false, // Настройка количества записей на странице
                paging: false, // Выключаем пагинацию
                info: false,
                language: {
                    emptyTable: "Нет данных",
                }
            });
        });
    </script>
@endsection
