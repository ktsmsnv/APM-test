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
                                aria-selected="true">СИнтег</a>
                        </li>
                        <!-- Вторая вкладка -->
                        <li class="nav-item flex-sm-fill">
                            <a class="nav-link border-0 text-uppercase font-weight-bold" id="EOB-tab" data-bs-toggle="tab"
                                href="#EOB" role="tab" data-toggle="tab" aria-controls="EOB"
                                aria-selected="false">ЭОБ</a>
                        </li>
                        <!-- Третья вкладка -->
                        <li class="nav-item flex-sm-fill">
                            <a class="nav-link border-0 text-uppercase font-weight-bold" id="NHRS-tab" data-bs-toggle="tab"
                                href="#NHRS" role="tab" data-toggle="tab" aria-controls="NHRS"
                                aria-selected="false">НХРС</a>
                        </li>
                        <!-- Четвёртая вкладка -->
                        <li class="nav-item flex-sm-fill">
                            <a class="nav-link border-0 text-uppercase font-weight-bold" id="Other-tab" data-bs-toggle="tab"
                                href="#Other" role="tab" data-toggle="tab" aria-controls="Other"
                                aria-selected="false">Прочее</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Содержимое первой вкладки -->
                        <div class="tab-pane fade show active" id="SInteg" role="tabpanel"
                            aria-labelledby="SInteg-tab">
                            <div class="card-body">
                                <table id="equipment-datatable-SInteg" class="display nowrap table" style="width:100%">
                                    <thead>
                                        <!-- Заголовки столбцов -->
                                        <tr>
                                            <th rowspan="2">№</th>
                                            <th rowspan="2">Вн. Номер</th>
                                            <th rowspan="2">Наим.закупки</th>
                                            <th colspan="8" class="text-center">Виды работ</th>
                                            <th rowspan="2">Наим. орг.закупки</th>
                                            <th rowspan="2">Головная компания</th>
                                            <th rowspan="2">Объект</th>
                                            <th rowspan="2">Площадка</th>
                                            <th rowspan="2">Дата поступления заявки</th>
                                            <th rowspan="2">Дата подачи предложения</th>
                                            <th rowspan="2">Руководитель проекта</th>
                                            <th rowspan="2">Тех.спец. выполнявший ТП</th>
                                            <th rowspan="2">Себестоимость</th>
                                            <th rowspan="2">Цена ТКП руб. с НДС</th>
                                            <th rowspan="2">Примечания</th>
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
                                        @foreach ($RegSInteg as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->vnNum }}</td>
                                                <td>{{ $item->purchaseName }}</td>
                                                <td>{{ $item->delivery }}</td>
                                                <td>{{ $item->pir }}</td>
                                                <td>{{ $item->kd }}</td>
                                                <td>{{ $item->prod }}</td>
                                                <td>{{ $item->shmr }}</td>
                                                <td>{{ $item->pnr }}</td>
                                                <td>{{ $item->po }}</td>
                                                <td>{{ $item->smr }}</td>
                                                <td>{{ $item->purchaseOrg }}</td>
                                                <td>{{ $item->endUser }}</td>
                                                <td>{{ $item->object }}</td>
                                                <td>{{ $item->area }}</td>
                                                <td>{{ date('d.m.Y', strtotime($item->receiptDate)) }}</td>
                                                <td>{{ date('d.m.Y', strtotime($item->submissionDate)) }}</td>
                                                <td>{{ $item->projectManager }}</td>
                                                <td>{{ $item->tech }}</td>
                                                <td>{{ $item->primeCost }}</td>
                                                <td>{{ $item->tkpCost }}</td>
                                                <td>{{ $item->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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
                                            <th rowspan="2">№</th>
                                            <th rowspan="2">Вн. Номер</th>
                                            <th rowspan="2">Наим.закупки</th>
                                            <th colspan="8" class="text-center">Виды работ</th>
                                            <th rowspan="2">Наим. орг.закупки</th>
                                            <th rowspan="2">Головная компания</th>
                                            <th rowspan="2">Объект</th>
                                            <th rowspan="2">Площадка</th>
                                            <th rowspan="2">Дата поступления заявки</th>
                                            <th rowspan="2">Дата подачи предложения</th>
                                            <th rowspan="2">Руководитель проекта</th>
                                            <th rowspan="2">Тех.спец. выполнявший ТП</th>
                                            <th rowspan="2">Себестоимость</th>
                                            <th rowspan="2">Цена ТКП руб. с НДС</th>
                                            <th rowspan="2">Примечания</th>
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
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->vnNum }}</td>
                                                <td>{{ $item->purchaseName }}</td>
                                                <td>{{ $item->delivery }}</td>
                                                <td>{{ $item->pir }}</td>
                                                <td>{{ $item->kd }}</td>
                                                <td>{{ $item->prod }}</td>
                                                <td>{{ $item->shmr }}</td>
                                                <td>{{ $item->pnr }}</td>
                                                <td>{{ $item->po }}</td>
                                                <td>{{ $item->smr }}</td>
                                                <td>{{ $item->purchaseOrg }}</td>
                                                <td>{{ $item->endUser }}</td>
                                                <td>{{ $item->object }}</td>
                                                <td>{{ $item->area }}</td>
                                                <td>{{ date('d.m.Y', strtotime($item->receiptDate)) }}</td>
                                                <td>{{ date('d.m.Y', strtotime($item->submissionDate)) }}</td>
                                                <td>{{ $item->projectManager }}</td>
                                                <td>{{ $item->tech }}</td>
                                                <td>{{ $item->primeCost }}</td>
                                                <td>{{ $item->tkpCost }}</td>
                                                <td>{{ $item->notes }}</td>
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
                                            <th rowspan="2">№</th>
                                            <th rowspan="2">Вн. Номер</th>
                                            <th rowspan="2">Наим.закупки</th>
                                            <th colspan="8" class="text-center">Виды работ</th>
                                            <th rowspan="2">Наим. орг.закупки</th>
                                            <th rowspan="2">Головная компания</th>
                                            <th rowspan="2">Объект</th>
                                            <th rowspan="2">Площадка</th>
                                            <th rowspan="2">Дата поступления заявки</th>
                                            <th rowspan="2">Дата подачи предложения</th>
                                            <th rowspan="2">Руководитель проекта</th>
                                            <th rowspan="2">Тех.спец. выполнявший ТП</th>
                                            <th rowspan="2">Себестоимость</th>
                                            <th rowspan="2">Цена ТКП руб. с НДС</th>
                                            <th rowspan="2">Примечания</th>
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
                                        @foreach ($RegNHRS as $el)
                                            <tr>
                                                <td>{{ $el->id }}</td>
                                                <td>{{ $el->vnNum }}</td>
                                                <td>{{ $el->purchaseName }}</td>
                                                <td>{{ $el->delivery }}</td>
                                                <td>{{ $el->pir }}</td>
                                                <td>{{ $el->kd }}</td>
                                                <td>{{ $el->prod }}</td>
                                                <td>{{ $el->shmr }}</td>
                                                <td>{{ $el->pnr }}</td>
                                                <td>{{ $el->po }}</td>
                                                <td>{{ $el->smr }}</td>
                                                <td>{{ $el->purchaseOrg }}</td>
                                                <td>{{ $el->endUser }}</td>
                                                <td>{{ $el->object }}</td>
                                                <td>{{ $el->area }}</td>
                                                <td>{{ date('d.m.Y', strtotime($el->receiptDate)) }}</td>
                                                <td>{{ date('d.m.Y', strtotime($el->submissionDate)) }}</td>
                                                <td>{{ $el->projectManager }}</td>
                                                <td>{{ $el->tech }}</td>
                                                <td>{{ $el->primeCost }}</td>
                                                <td>{{ $el->tkpCost }}</td>
                                                <td>{{ $el->notes }}</td>

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
                                            <th rowspan="2">№</th>
                                            <th rowspan="2">Вн. Номер</th>
                                            <th rowspan="2">Наим.закупки</th>
                                            <th colspan="8" class="text-center">Виды работ</th>
                                            <th rowspan="2">Наим. орг.закупки</th>
                                            <th rowspan="2">Головная компания</th>
                                            <th rowspan="2">Объект</th>
                                            <th rowspan="2">Площадка</th>
                                            <th rowspan="2">Дата поступления заявки</th>
                                            <th rowspan="2">Дата подачи предложения</th>
                                            <th rowspan="2">Руководитель проекта</th>
                                            <th rowspan="2">Тех.спец. выполнявший ТП</th>
                                            <th rowspan="2">Себестоимость</th>
                                            <th rowspan="2">Цена ТКП руб. с НДС</th>
                                            <th rowspan="2">Примечания</th>
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
                                        @foreach ($RegOther as $el)
                                            <tr>
                                                <td>{{ $el->id }}</td>
                                                <td>{{ $el->vnNum }}</td>
                                                <td>{{ $el->purchaseName }}</td>
                                                <td>{{ $el->delivery }}</td>
                                                <td>{{ $el->pir }}</td>
                                                <td>{{ $el->kd }}</td>
                                                <td>{{ $el->prod }}</td>
                                                <td>{{ $el->shmr }}</td>
                                                <td>{{ $el->pnr }}</td>
                                                <td>{{ $el->po }}</td>
                                                <td>{{ $el->smr }}</td>
                                                <td>{{ $el->purchaseOrg }}</td>
                                                <td>{{ $el->endUser }}</td>
                                                <td>{{ $el->object }}</td>
                                                <td>{{ $el->area }}</td>
                                                <td>{{ date('d.m.Y', strtotime($el->receiptDate)) }}</td>
                                                <td>{{ date('d.m.Y', strtotime($el->submissionDate)) }}</td>
                                                <td>{{ $el->projectManager }}</td>
                                                <td>{{ $el->tech }}</td>
                                                <td>{{ $el->primeCost }}</td>
                                                <td>{{ $el->tkpCost }}</td>
                                                <td>{{ $el->notes }}</td>

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
    
    <script>
        $(document).ready(function() {
            // Инициализируются настройки открытой вкладки с таблицой
            $('#equipment-datatable-SInteg').DataTable({
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
    </script>
@endsection
