@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-18">
                <h1 class="mb-5">Карта проекта Вн. Номер: {{ $project->projNum }}</h1>

                <ul class="nav nav-mytabs mb-5" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="calculation-tab" data-toggle="tab" href="#calculation" role="tab"
                            aria-controls="calculation" aria-selected="true">Расчет</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="realization-tab" data-toggle="tab" href="#realization" role="tab"
                            aria-controls="realization" aria-selected="false">Реализация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="risks-tab" data-toggle="tab" href="#risks" role="tab"
                            aria-controls="risks" aria-selected="false">Риски</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="changes-tab" data-toggle="tab" href="#changes" role="tab"
                            aria-controls="changes" aria-selected="false">Изменения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="report-tab" data-toggle="tab" href="#report" role="tab"
                            aria-controls="report" aria-selected="false">Отчет</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="smk-tab" data-toggle="tab" href="#smk" role="tab"
                            aria-controls="smk" aria-selected="false">СМК</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab"
                            aria-controls="notes" aria-selected="false">Дневник проекта</a>
                    </li>
                </ul>


                <div class="tab-content mytab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="calculation" role="tabpanel"
                        aria-labelledby="calculation-tab">
                        @include('tables.calculation-projectMap')
                    </div>
                    <div class="tab-pane fade" id="realization" role="tabpanel"
                        aria-labelledby="realization-tab">
                        @include('tables.realization-projectMap')
                    </div>
                    <div class="tab-pane fade" id="risks" role="tabpanel" aria-labelledby="risks-tab">
                        @include('tables.risks-projectMap')
                    </div>
                    <div class="tab-pane fade" id="changes" role="tabpanel" aria-labelledby="changes-tab">
                        @include('tables.changes-projectMap')
                    </div>
                    <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
                        @include('tables.report-projectMap')
                    </div>
                    <div class="tab-pane fade" id="smk" role="tabpanel" aria-labelledby="smk-tab">
                        СМК
                    </div>
                    <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                        @include('tables.notes-projectMap')
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


        $(document).ready(() => {
            let url = location.href.replace(/\/$/, "");

            // Function to load content for a specific tab
            function loadTabContent(tabId) {
                // Use AJAX to fetch content dynamically
                $.ajax({
                    url: `/tables/${tabId}`, // Use the new endpoint
                    type: 'GET',
                    success: function(response) {
                        // Update the content of the tab with the received data
                        $(`#${tabId}`).html(response.content);

                        // Show the tab
                        $(`#myTab a[href="#${tabId}"]`).tab("show");
                    },
                    error: function(error) {
                        console.error('Error fetching tab content:', error);
                    }
                });
            }

            // Show the tab if there's a hash in the URL
            if (location.hash) {
                const hash = url.split("#");
                loadTabContent(hash[1]);
                url = location.href.replace(/\/#/, "#");
                history.replaceState(null, null, url);
                setTimeout(() => {
                    $(window).scrollTop(0);
                }, 400);
            }

            // Handle tab clicks
            $('a[data-toggle="tab"]').on("click", function() {
                // Construct a new URL based on the clicked tab's hash
                const newUrl = `${url.split("#")[0]}${$(this).attr("href")}/`;

                // Replace the current state in the history with the new URL
                history.replaceState(null, null, newUrl);

                // Load content for the clicked tab
                const tabId = $(this).attr("aria-controls");
                loadTabContent(tabId);
            });
        });
    </script>
@endsection
