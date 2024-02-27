@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-18">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Реестр</h2>
                </div>

                <div class="card__main">
                    <ul class="nav nav-mytabs" id="myTab" role="tablist">
                        <!-- Первая вкладка (активная) -->
                        <li class="nav-item flex-sm-fill">
                            <a class="nav-link border-0 text-uppercase font-weight-bold active" id="SInteg-tab"
                                data-bs-toggle="tab" href="#SInteg" role="tab" data-toggle="tab" aria-controls="SInteg"
                                aria-selected="true">Группа 1</a>
                        </li>
                        <!-- Вторая вкладка -->
                        <li class="nav-item flex-sm-fill">
                            <a class="nav-link border-0 text-uppercase font-weight-bold" id="EOB-tab" data-bs-toggle="tab"
                                href="#EOB" role="tab" data-toggle="tab" aria-controls="EOB"
                                aria-selected="false">Группа 2</a>
                        </li>
                        <!-- Третья вкладка -->
                        <li class="nav-item flex-sm-fill">
                            <a class="nav-link border-0 text-uppercase font-weight-bold" id="NHRS-tab" data-bs-toggle="tab"
                                href="#NHRS" role="tab" data-toggle="tab" aria-controls="NHRS"
                                aria-selected="false">Группа 3</a>
                        </li>
                        <!-- Четвёртая вкладка -->
                        <li class="nav-item flex-sm-fill">
                            <a class="nav-link border-0 text-uppercase font-weight-bold" id="Other-tab" data-bs-toggle="tab"
                                href="#Other" role="tab" data-toggle="tab" aria-controls="Other"
                                aria-selected="false">Группа 4</a>
                        </li>
                    </ul>


                    <div class="tab-content" id="myTabContent">
                        <!-- Содержимое первой вкладки -->
                        <div class="tab-pane fade show active" id="SInteg" role="tabpanel" aria-labelledby="SInteg-tab">
                            <div class="card-body">
                                <table id="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true"
                                    data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true"
                                    data-show-columns-toggle-all="true" data-detail-view="true" data-show-export="true"
                                    data-click-to-select="true" data-detail-formatter="detailFormatter"
                                    data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true"
                                    data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="server"
                                    data-url="/getData_group_1" data-response-handler="responseHandler">
                                </table>
                            </div>
                        </div>
                        <!-- Содержимое второй вкладки -->
                        <div class="tab-pane fade" id="EOB" role="tabpanel" aria-labelledby="EOB-tab">
                            <div class="card-body">
                                <table id="equipment-datatable-EOB" class="display nowrap table" style="width:100%">
                                    <thead>
                                        <!-- Заголовки столбцов -->
                                        <tr>
                                            {{-- <th rowspan="2">№</th> --}}
                                            <th rowspan="2">Вн. Номер</th>
                                            <th rowspan="2">Наим.закупки</th>
                                            <th colspan="8" class="text-center">Виды работ</th>
                                            <th rowspan="2">Наим. орг.закупки</th>
                                            <th rowspan="2">Головная компания</th>
                                            <th rowspan="2">Объект</th>
                                            {{-- <th rowspan="2">Площадка</th> --}}
                                            <th rowspan="2">Дата поступления заявки</th>
                                            <th rowspan="2">Дата подачи предложения</th>
                                            <th rowspan="2">Руководитель проекта</th>
                                            {{-- <th rowspan="2">Тех.спец. выполнявший ТП</th>
                                            <th rowspan="2">Себестоимость</th>
                                            <th rowspan="2">Цена ТКП руб. с НДС</th>
                                            <th rowspan="2">Примечания</th> --}}
                                        </tr>
                                        <tr>
                                            <th>Поставка</th>
                                            <th>ПИР</th>
                                            <th>КД</th>
                                            <th>Про-во</th>
                                            <th>ШМР</th>
                                            <th>ПНР</th>
                                            <th>ПО</th>
                                            <th>СМР</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Контент таблицы -->
                                        @foreach ($RegEOB as $item)
                                            <tr>
                                                {{-- <td>{{ $item->id }}</td> --}}
                                                <td>{{ $item->vnNum }}</td>
                                                <td>{{ $item->purchaseName }}</td>

                                                <td class="{{ $item->delivery == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->delivery }} --}}
                                                </td>
                                                <td class="{{ $item->pir == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->pir }} --}}
                                                </td>
                                                <td class="{{ $item->kd == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->kd }} --}}
                                                </td>
                                                <td class="{{ $item->prod == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->prod }} --}}
                                                </td>
                                                <td class="{{ $item->shmr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->shmr }} --}}
                                                </td>
                                                <td class="{{ $item->pnr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->pnr }} --}}
                                                </td>
                                                <td class="{{ $item->po == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->po }} --}}
                                                </td>
                                                <td class="{{ $item->smr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->smr }} --}}
                                                </td>

                                                <td>{{ $item->purchaseOrg }}</td>
                                                <td>{{ $item->endUser }}</td>
                                                <td>{{ $item->object }}</td>
                                                {{-- <td>{{ $item->area }}</td> --}}
                                                <td>{{ date('d.m.Y', strtotime($item->receiptDate)) }}</td>
                                                {{-- <td>{{ date('d.m.Y', strtotime($item->submissionDate)) }}</td> --}}
                                                <td>{{ $item->submissionDate ? date('d.m.Y', strtotime($item->submissionDate)) : '-' }}
                                                </td>
                                                <td>{{ $item->projectManager }}</td>
                                                {{-- <td>{{ $item->tech }}</td>
                                                <td>{{ $item->primeCost }}</td>
                                                <td>{{ $item->tkpCost }}</td>
                                                <td>{{ $item->notes }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Содержимое третьей вкладки -->
                        <div class="tab-pane fade" id="NHRS" role="tabpanel" aria-labelledby="NHRS-tab">
                            <div class="card-body">
                                <table id="equipment-datatable-NHRS" class="display nowrap table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- Заголовки столбцов -->
                                        <tr>
                                            {{-- <th rowspan="2">№</th> --}}
                                            <th rowspan="2">Вн. Номер</th>
                                            <th rowspan="2">Наим.закупки</th>
                                            <th colspan="8" class="text-center">Виды работ</th>
                                            <th rowspan="2">Наим. орг.закупки</th>
                                            <th rowspan="2">Головная компания</th>
                                            <th rowspan="2">Объект</th>
                                            {{-- <th rowspan="2">Площадка</th> --}}
                                            <th rowspan="2">Дата поступления заявки</th>
                                            <th rowspan="2">Дата подачи предложения</th>
                                            <th rowspan="2">Руководитель проекта</th>
                                            {{-- <th rowspan="2">Тех.спец. выполнявший ТП</th>
                                            <th rowspan="2">Себестоимость</th>
                                            <th rowspan="2">Цена ТКП руб. с НДС</th>
                                            <th rowspan="2">Примечания</th> --}}
                                        </tr>
                                        <tr>
                                            <th>Поставка</th>
                                            <th>ПИР</th>
                                            <th>КД</th>
                                            <th>Про-во</th>
                                            <th>ШМР</th>
                                            <th>ПНР</th>
                                            <th>ПО</th>
                                            <th>СМР</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Контент таблицы -->
                                        @foreach ($RegNHRS as $item)
                                            <tr>
                                                {{-- <td>{{ $item->id }}</td> --}}
                                                <td>{{ $item->vnNum }}</td>
                                                <td>{{ $item->purchaseName }}</td>

                                                <td class="{{ $item->delivery == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->delivery }} --}}
                                                </td>
                                                <td class="{{ $item->pir == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->pir }} --}}
                                                </td>
                                                <td class="{{ $item->kd == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->kd }} --}}
                                                </td>
                                                <td class="{{ $item->prod == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->prod }} --}}
                                                </td>
                                                <td class="{{ $item->shmr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->shmr }} --}}
                                                </td>
                                                <td class="{{ $item->pnr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->pnr }} --}}
                                                </td>
                                                <td class="{{ $item->po == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->po }} --}}
                                                </td>
                                                <td class="{{ $item->smr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->smr }} --}}
                                                </td>

                                                <td>{{ $item->purchaseOrg }}</td>
                                                <td>{{ $item->endUser }}</td>
                                                <td>{{ $item->object }}</td>
                                                {{-- <td>{{ $item->area }}</td> --}}
                                                <td>{{ date('d.m.Y', strtotime($item->receiptDate)) }}</td>
                                                {{-- <td>{{ date('d.m.Y', strtotime($item->submissionDate)) }}</td> --}}
                                                <td>{{ $item->submissionDate ? date('d.m.Y', strtotime($item->submissionDate)) : '-' }}
                                                </td>
                                                <td>{{ $item->projectManager }}</td>
                                                {{-- <td>{{ $item->tech }}</td>
                                                <td>{{ $item->primeCost }}</td>
                                                <td>{{ $item->tkpCost }}</td>
                                                <td>{{ $item->notes }}</td> --}}

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Содержимое четвёртой вкладки -->
                        <div class="tab-pane fade" id="Other" role="tabpanel" aria-labelledby="Other-tab">
                            <div class="card-body">
                                <table id="equipment-datatable-Other" class="display nowrap table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- Заголовки столбцов -->
                                        <tr>
                                            {{-- <th rowspan="2">№</th> --}}
                                            <th rowspan="2">Вн. Номер</th>
                                            <th rowspan="2">Наим.закупки</th>
                                            <th colspan="8" class="text-center">Виды работ</th>
                                            <th rowspan="2">Наим. орг.закупки</th>
                                            <th rowspan="2">Головная компания</th>
                                            <th rowspan="2">Объект</th>
                                            {{-- <th rowspan="2">Площадка</th> --}}
                                            <th rowspan="2">Дата поступления заявки</th>
                                            <th rowspan="2">Дата подачи предложения</th>
                                            <th rowspan="2">Руководитель проекта</th>
                                            {{-- <th rowspan="2">Тех.спец. выполнявший ТП</th>
                                            <th rowspan="2">Себестоимость</th>
                                            <th rowspan="2">Цена ТКП руб. с НДС</th>
                                            <th rowspan="2">Примечания</th> --}}
                                        </tr>
                                        <tr>
                                            <th>Поставка</th>
                                            <th>ПИР</th>
                                            <th>КД</th>
                                            <th>Про-во</th>
                                            <th>ШМР</th>
                                            <th>ПНР</th>
                                            <th>ПО</th>
                                            <th>СМР</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Контент таблицы -->
                                        @foreach ($RegOther as $item)
                                            <tr>
                                                {{-- <td>{{ $item->id }}</td> --}}
                                                <td>{{ $item->vnNum }}</td>
                                                <td>{{ $item->purchaseName }}</td>

                                                <td class="{{ $item->delivery == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->delivery }} --}}
                                                </td>
                                                <td class="{{ $item->pir == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->pir }} --}}
                                                </td>
                                                <td class="{{ $item->kd == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->kd }} --}}
                                                </td>
                                                <td class="{{ $item->prod == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->prod }} --}}
                                                </td>
                                                <td class="{{ $item->shmr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->shmr }} --}}
                                                </td>
                                                <td class="{{ $item->pnr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->pnr }} --}}
                                                </td>
                                                <td class="{{ $item->po == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->po }} --}}
                                                </td>
                                                <td class="{{ $item->smr == 1 ? 'red-cell' : '' }}">
                                                    {{-- {{ $item->smr }} --}}
                                                </td>

                                                <td>{{ $item->purchaseOrg }}</td>
                                                <td>{{ $item->endUser }}</td>
                                                <td>{{ $item->object }}</td>
                                                {{-- <td>{{ $el->area }}</td> --}}
                                                <td>{{ date('d.m.Y', strtotime($item->receiptDate)) }}</td>
                                                {{-- <td>{{ date('d.m.Y', strtotime($item->submissionDate)) }}</td> --}}
                                                <td>{{ $item->submissionDate ? date('d.m.Y', strtotime($item->submissionDate)) : '-' }}
                                                </td>
                                                <td>{{ $item->projectManager }}</td>
                                                {{-- <td>{{ $el->tech }}</td>
                                                <td>{{ $el->primeCost }}</td>
                                                <td>{{ $el->tkpCost }}</td>
                                                <td>{{ $el->notes }}</td> --}}

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        $(document).ready(function() {
            // Инициализируются настройки открытой вкладки с таблицой
            $('#equipment-datatable-SInteg').DataTable({
                retrieve: true,
                responsive: true,
                columnDefs: [{
                        width: "10%",
                        targets: 0
                    }, // Первый столбец
                    {
                        width: "20%",
                        targets: 1
                    }, // Второй столбец
                ],
                pageLength: 15, // Количество записей на странице по умолчанию
                lengthMenu: [15, 35, 50, 100, -1], // Выбор количества записей
                language: {
                    search: 'Поиск:',
                    info: 'Показано с _START_ по _END_ из _TOTAL_ записей',
                    infoEmpty: 'Записи не найдены',
                    infoFiltered: '(отфильтровано из _MAX_ записей)',
                    lengthMenu: 'Показать _MENU_ записей',
                    sEmptyTable: "НЕТ ЗАПИСЕЙ В ТАБЛИЦЕ",
                    paginate: {
                        next: 'Следующая',
                        previous: 'Предыдущая',
                    },
                },
                // Добавьте следующий блок для замены -1 на "все"
                initComplete: function() {
                    var select = $('select[name="equipment-datatable-SInteg_length"]');
                    select.find('option[value="-1"]').text('Все');
                }
            });

            // Инициализируются остальные вкладки с таблицами, при их открывании
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href"); // получаем id вкладки

                if (target === "#SInteg" || target === "#EOB" || target === "#NHRS" || target ===
                    "#Other") {
                    // Применяем настройки для таблицы
                    var table = $(target + ' table').DataTable({
                        retrieve: true,
                        responsive: true,
                        rowReorder: {
                            selector: 'td:nth-child(2)'
                        },
                        columnDefs: [{
                            width: "10%",
                            targets: 0
                        }],
                        pageLength: 15, // Количество записей на странице по умолчанию
                        lengthMenu: [15, 35, 50, 100, -1], // Выбор количества записей
                        language: {
                            search: 'Поиск:',
                            info: 'Показано с _START_ по _END_ из _TOTAL_ записей',
                            infoEmpty: 'Записи не найдены',
                            infoFiltered: '(отфильтровано из _MAX_ записей)',
                            lengthMenu: 'Показать _MENU_ записей',
                            sEmptyTable: "НЕТ ЗАПИСЕЙ В ТАБЛИЦЕ",
                            paginate: {
                                next: 'Следующая',
                                previous: 'Предыдущая',
                            },
                        },
                        // Добавьте следующий блок для замены -1 на "все"
                        initComplete: function() {
                            var select = $('select[name="equipment-datatable-' + target
                                .substring(1) + '_length"]');
                            select.find('option[value="-1"]').text('Все');
                        }
                    });
                }
            });
        });
    </script> --}}

    <script>
        var $table = $('#table');
        var $remove = $('#remove');
        var selections = [];

        function getIdSelections() {
            return $.map($table.bootstrapTable('getSelections'), function(row) {
                return row.id;
            });
        }

        function responseHandler(res) {
            $.each(res.rows, function(i, row) {
                row.state = $.inArray(row.id, selections) !== -1;
            });
            return res;
        }

        $(function() {
            // Отправляем AJAX запрос и при получении данных инициализируем таблицу
            $.get('/getData_group_1', function(data) {
                initTable(data);
            }).done(function(data) {
                var totalRows = data.RegSInteg.length; // Получаем общее количество строк
            });
        });
        
        function detailFormatter(index, row) {
            var fieldNames = {
                'vnNum': 'Вн. Номер',
                'purchaseName': 'Наим. закупки',
                'delivery': 'Поставка',
                'pir': 'ПИР',
                'kd': 'КД',
                'prod': 'Пр-во',
                'shmr': 'ШМР',
                'pnr': 'ПНР',
                'po': 'ПО',
                'smr': 'СМР',
                'purchaseOrg': 'Наим. орг. закупки',
                'endUser': 'Головная компания',
                'object': 'объект',
                'receiptDate': 'Дата поступления заявки',
                'submissionDate': 'Дата подачи предложения',
                'projectManager': 'Руководитель проекта',
            };

            var html = [];
            $.each(row, function(key, value) {
                var fieldName = fieldNames[key] ||
                    key; // Получаем название поля из объекта fieldNames или используем ключ, если название не найдено
                if (key !== 'area' && key !== 'id' && key !== 'tech' && key !== 'primeCost' && key !== 'tkpCost' &&
                    key !== 'notes' && key !== 'created_at' && key !== 'updated_at') {
                    html.push('<p><b>' + fieldName + ':</b> ' + value + '</p>');
                }
            });
            return html.join('');
        }


        function initTable(data) {
            $table.bootstrapTable('destroy').bootstrapTable({
                // height: 550,
                locale: $('#locale').val(),
                data: data.RegSInteg, // Передаем данные из AJAX запроса
                columns: [
                    [{
                        title: 'Вн. Номер',
                        field: 'vnNum',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true,
                    }, {
                        title: 'Наим. закупки',
                        field: 'purchaseName',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }, {
                        title: 'Виды работ',
                        colspan: 8,
                        align: 'center'
                    }, {
                        title: 'Наим. орг. закупки',
                        field: 'purchaseOrg',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }, {
                        title: 'Головная компания',
                        field: 'endUser',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }, {
                        title: 'Объект',
                        field: 'object',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }, {
                        title: 'Дата поступления заявки',
                        field: 'receiptDate',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }, {
                        title: 'Дата подачи предложения',
                        field: 'submissionDate',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }, {
                        title: 'Руководитель проекта',
                        field: 'projectManager',
                        rowspan: 2,
                        align: 'center',
                        valign: 'middle',
                        sortable: true
                    }],
                    [{
                        field: 'delivery',
                        title: 'Поставка',
                        sortable: true
                    }, {
                        field: 'pir',
                        title: 'ПИР',
                        sortable: true
                    }, {
                        field: 'kd',
                        title: 'КД',
                        sortable: true
                    }, {
                        field: 'prod',
                        title: 'Пр-во',
                        sortable: true
                    }, {
                        field: 'shmr',
                        title: 'ШМР',
                        sortable: true
                    }, {
                        field: 'pnr',
                        title: 'ПНР',
                        sortable: true
                    }, {
                        field: 'po',
                        title: 'ПО',
                        sortable: true
                    }, {
                        field: 'smr',
                        title: 'СМР',
                        sortable: true
                    }]
                ],
                formatSearch: function() {
                    return 'Поиск';
                },
                formatShowingRows: function(pageFrom, pageTo, totalRows) {
                    return 'Показано с ' + pageFrom + ' по ' + pageTo + ' из ' + totalRows + ' строк';
                },
                formatRecordsPerPage: function(pageNumber) {
                    return pageNumber + ' строк на странице';
                },
                ajaxOptions: {
                    success: function(data) {
                        $('#table').bootstrapTable('load', data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                }
            });
        }
    </script>
@endsection
