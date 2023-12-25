@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">Реестр рисков и возможностей</h1>

        {{-- ----------------------- РИСКИ ----------------------- --}}
        <div class="d-flex align-items-center gap-3 ms-3">
            <h2 class="mb-4">Риски</h2>
            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addBaseRisks">Добавить риски</button>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                @csrf
                <table class="display nowrap table" id="baseRisksTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Наименование риска</th>
                            <th>Причина риска</th>
                            <th>Последствия наступления риска</th>
                            <th>Противодействие риску</th>
                            <th>Срок</th>
                            <th>Мероприятия при осуществлении риска</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($baseRisks as $item)
                            <tr class="editable-row" data-id="{{ $item->id }}">
                                <td data-label="id">
                                    {{ $item->id }}
                                </td>
                                <td data-label="nameRisk">
                                    {{ $item->nameRisk }}
                                </td>
                                <td data-label="reasonRisk" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($item->reasonRisk) as $reason)
                                            <li>{{ $reason->reasonRisk }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td data-label="conseqRiskOnset" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($item->conseqRiskOnset) as $index => $conseq)
                                            <li>{{ $conseq->conseqRiskOnset }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td data-label="counteringRisk" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($item->counteringRisk) as $index => $countering)
                                            <li>{{ $countering->counteringRisk }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td data-label="term">
                                    {{ $item->term }}
                                </td>
                                <td data-label="riskManagMeasures" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($item->riskManagMeasures) as $index => $measure)
                                            <li>{{ $measure->riskManagMeasures }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="editProduct btn btn-xs btn-info" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editBaseRisks" data-id="{{ $item->id }}"><i
                                                class="fa-solid fa-edit"></i></a>
                                        <a class="deleteProduct btn btn-xs btn-danger" href="#" data-bs-toggle="modal"
                                            data-bs-target="#confirmationModal" data-id="{{ $item->id }}"><i
                                                class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Модальное окно формирование нового риска --}}
        <div class="modal fade" id="addBaseRisks" tabindex="-1" aria-labelledby="addBaseRisksLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="{{ route('baseRisks-store') }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBaseRisksLabel">Добавление риска</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group mb-3">
                                <label>Наименование риска</label>
                                <input type="text" class="form-control" name="nameRisk" id="nameRisk"
                                    placeholder="Введите наименование риска">
                            </div>

                            <div id="reason_risk-inputs">
                                <div class="form-group mb-2">
                                    <label>Причина риска</label>
                                    <input type="text" class="form-control" name="reason_risk[0][reasonRisk]"
                                        id="reasonRisk" placeholder="Введите причину риска">
                                </div>
                            </div>
                            <button id="addMore-reason_risk" data-target="reason_risk"
                                class="btn btn-secondary addMore-button mb-3">Добавить еще риск</button>

                            <div id="conseq_risk-inputs">
                                <div class="form-group mb-3">
                                    <label>Последствия наступления риска</label>
                                    <input type="text" class="form-control" name="conseq_risk[0][conseqRiskOnset]"
                                        id="conseqRiskOnset" placeholder="Введите последствия наступления риска">
                                </div>
                            </div>
                            <button id="addMore-conseq_risk" data-target="conseq_risk"
                                class="btn btn-secondary addMore-button mb-3">Добавить еще последствия</button>
                            <div id="countering_risk-inputs">
                                <div class="form-group mb-3">
                                    <label>Противодействие риску</label>
                                    <input type="text" class="form-control" name="countering_risk[0][counteringRisk]"
                                        id="counteringRisk" placeholder="Введите противодействие риску">
                                </div>
                            </div>
                            <button id="addMore-countering_risk" data-target="countering_risk"
                                class="btn btn-secondary addMore-button mb-3">Добавить еще противодействие</button>

                            <div class="form-group mb-3">
                                <label>Срок</label>
                                <input type="text" class="form-control" name="term" id="term"
                                    placeholder="Введите срок">
                            </div>
                            <div id="measures_risk-inputs">
                                <div class="form-group mb-3">
                                    <label>Мероприятия при осуществлении риска</label>
                                    <input type="text" class="form-control" name="measures_risk[0][riskManagMeasures]"
                                        id="riskManagMeasures" placeholder="Введите мероприятия при осуществлении риска">
                                </div>
                            </div>
                            <button id="addMore-measures_risk" data-target="measures_risk"
                                class="btn btn-secondary addMore-button mb-3">Добавить еще мероприятия</button>

                        </div>
                        {{-- Кнопки --}}
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Добавить</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- если заиси в таблице рисков существуют --}}
        @if ($baseRisks->count() > 0)
            {{-- Модальное окно редактирования риска --}}
            <div class="modal fade" id="editBaseRisks" tabindex="-1" role="dialog"
                aria-labelledby="editBaseRisksLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form id="editBaseRisksForm" action="{{ route('baseRisks-update', ['id' => $item->id]) }}"
                        method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editBaseRisksLabel">Редактирование риска
                                    "{{ $item->nameRisk }}"</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="editItemId" id="editItemId">
                                <input type="hidden" name="jsonData" id="jsonData">

                                <div class="form-group mb-3">
                                    <label for="nameRiskEdit">Наименование риска</label>
                                    <input type="text" class="form-control" name="nameRisk" id="nameRiskEdit"
                                        placeholder="Введите наименование риска">
                                </div>

                                <div id="reason_riskEdit-inputs" class="form-group mb-2">
                                    <label>Причина риска</label>
                                    <div id="reasonRiskEdit"></div>
                                </div>
                                <button id="addMoreEdit-reason_risk" data-target="reason_riskEdit"
                                    class="btn btn-secondary addMoreEdit-button mb-3">Добавить еще риск</button>

                                <div id="conseq_riskEdit-inputs" class="form-group mb-3">
                                    <label>Последствия наступления риска</label>
                                    <div id="conseqRiskOnsetEdit"></div>
                                </div>
                                <button id="addMoreEdit-conseq_risk" data-target="conseq_riskEdit"
                                    class="btn btn-secondary addMoreEdit-button mb-3">Добавить еще последствия</button>

                                <div id="countering_riskEdit-inputs" class="form-group mb-3">
                                    <label>Противодействие риску</label>
                                    <div id="counteringRiskEdit"></div>
                                </div>
                                <button id="addMoreEdit-countering_risk" data-target="countering_riskEdit"
                                    class="btn btn-secondary addMoreEdit-button mb-3">Добавить еще противодействие</button>

                                <div class="form-group mb-3">
                                    <label for="termEdit">Срок</label>
                                    <input type="text" class="form-control" name="term" id="termEdit"
                                        placeholder="Введите срок">
                                </div>

                                <div id="measures_riskEdit-inputs" class="form-group mb-3">
                                    <label>Мероприятия при осуществлении риска</label>
                                    <div id="riskManagMeasuresEdit"></div>
                                </div>
                                <button id="addMoreEdit-measures_risk" data-target="measures_riskEdit"
                                    class="btn btn-secondary addMoreEdit-button mb-3">Добавить еще мероприятия</button>

                            </div>
                            {{-- Кнопки --}}
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Сохранить</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Модальное окно уведомление подтверждение об удалении записи --}}
            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Подтверждение действия</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Вы уверены что хотите удалить риск "{{ $item->nameRisk }}"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
        @endif



        {{-- ----------------------- ВОЗМОЖНОСТИ ----------------------- --}}
        <div class="d-flex align-items-center gap-3 ms-3">
            <h2 class="mb-4">Возможности</h2>
            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addBasePossibilities">Добавить
                возможности</button>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                @csrf
                <table class="display nowrap table" id="basePossibilitiesTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Наименование риска</th>
                            <th>Причина риска</th>
                            <th>Последствия наступления риска</th>
                            <th>Противодействие риску</th>
                            <th>Срок</th>
                            <th>Мероприятия при осуществлении риска</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($basePossibilities as $possibility)
                            <tr class="editable-row" data-id="{{ $possibility->id }}">
                                <td data-label="id">
                                    {{ $possibility->id }}
                                </td>
                                <td data-label="nameRisk">
                                    {{ $possibility->nameRisk }}
                                </td>
                                <td data-label="reasonRisk" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($possibility->reasonRisk) as $reason)
                                            <li>{{ $reason->reasonRisk }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td data-label="conseqRiskOnset" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($possibility->conseqRiskOnset) as $index => $conseq)
                                            <li>{{ $conseq->conseqRiskOnset }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td data-label="counteringRisk" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($possibility->counteringRisk) as $index => $countering)
                                            <li>{{ $countering->counteringRisk }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td data-label="term">
                                    {{ $possibility->term }}
                                </td>
                                <td data-label="riskManagMeasures" class="json_array">
                                    <ol class="json_field">
                                        @foreach (json_decode($possibility->riskManagMeasures) as $index => $measure)
                                            <li>{{ $measure->riskManagMeasures }}</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a class="editPossibilities btn btn-xs btn-info" href="#"
                                            data-bs-toggle="modal" data-bs-target="#editBasePossibilities"
                                            data-id="{{ $possibility->id }}"><i class="fa-solid fa-edit"></i></a>
                                        <a class="deletePossibilities btn btn-xs btn-danger" href="#"
                                            data-bs-toggle="modal" data-bs-target="#confirmationModal_Possibilities"
                                            data-id="{{ $possibility->id }}"><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Модальное окно формирование новой возможности --}}
        <div class="modal fade" id="addBasePossibilities" tabindex="-1" aria-labelledby="addBasePossibilitiesLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="{{ route('basePossibilities-store') }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBasePossibilitiesLabel">Добавление возможности</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group mb-3">
                                <label>Наименование возможности</label>
                                <input type="text" class="form-control" name="nameRisk" id="nameRisk"
                                    placeholder="Введите наименование возможности">
                            </div>

                            <div id="reason_possib-inputs">
                                <div class="form-group mb-2">
                                    <label>Причина возможности</label>
                                    <input type="text" class="form-control" name="reason_risk[0][reasonRisk]"
                                        id="reasonRisk" placeholder="Введите причину возможности">
                                </div>
                            </div>
                            <button id="addMore-reason_possib" data-target="reason_possib"
                                class="btn btn-secondary addMorePossibilities-button mb-3" type="button">Добавить еще
                                возможность</button>

                            <div id="conseq_possib-inputs">
                                <div class="form-group mb-3">
                                    <label>Последствия наступления возможности</label>
                                    <input type="text" class="form-control" name="conseq_risk[0][conseqRiskOnset]"
                                        id="conseqRiskOnset" placeholder="Введите последствия наступления возможности">
                                </div>
                            </div>
                            <button id="addMore-conseq_possib" data-target="conseq_possib"
                                class="btn btn-secondary addMorePossibilities-button mb-3" type="button">Добавить еще
                                последствия</button>
                            <div id="countering_possib-inputs">
                                <div class="form-group mb-3">
                                    <label>Мероприятия в отношении возникновения возможностей</label>
                                    <input type="text" class="form-control" name="countering_risk[0][counteringRisk]"
                                        id="counteringRisk"
                                        placeholder="Введите мероприятие в отношении возникновения возможностей">
                                </div>
                            </div>
                            <button id="addMore-countering_possib" data-target="countering_possib"
                                class="btn btn-secondary addMorePossibilities-button mb-3" type="button">Добавить еще
                                мероприятие</button>

                            <div class="form-group mb-3">
                                <label>Срок</label>
                                <input type="text" class="form-control" name="term" id="term"
                                    placeholder="Введите срок">
                            </div>
                            <div id="measures_possib-inputs">
                                <div class="form-group mb-3">
                                    <label>Мероприятия при осуществлении возможности</label>
                                    <input type="text" class="form-control" name="measures_risk[0][riskManagMeasures]"
                                        id="riskManagMeasures"
                                        placeholder="Введите мероприятия при осуществлении возможности">
                                </div>
                            </div>
                            <button id="addMore-measures_possib" data-target="measures_possib"
                                class="btn btn-secondary addMorePossibilities-button mb-3" type="button">Добавить еще
                                мероприятия</button>

                        </div>
                        {{-- Кнопки --}}
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Добавить</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- если заиси в таблице возможностей существуют --}}
        @if ($basePossibilities->count() > 0)
            {{-- Модальное окно редактирования возможности --}}
            <div class="modal fade" id="editBasePossibilities" tabindex="-1" role="dialog"
                aria-labelledby="editBasePossibilitiesLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form id="editBasePossibilitiesForm"
                        action="{{ route('basePossibilities-update', ['id' => $possibility->id]) }}" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editBasePossibilitiesLabel">Редактирование возможности
                                    "{{ $possibility->nameRisk }}"</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="editItemId" id="editItemId_possib">
                                <input type="hidden" name="jsonData" id="jsonData">

                                <div class="form-group mb-3">
                                    <label for="nameRiskEdit_possib">Наименование возможности</label>
                                    <input type="text" class="form-control" name="nameRisk" id="nameRiskEdit_possib"
                                        placeholder="Введите наименование возможности">
                                </div>

                                <div id="reason_possibEdit-inputs" class="form-group mb-2">
                                    <label>Причина возможности</label>
                                    <div id="reasonRiskEdit_possib"></div>
                                </div>
                                <button id="addMoreEdit-reason_risk" data-target="reason_possibEdit"
                                    class="btn btn-secondary addMoreEditPossibilities-button mb-3">Добавить еще
                                    причины</button>

                                <div id="conseq_possibEdit-inputs" class="form-group mb-3">
                                    <label>Последствия наступления возможности</label>
                                    <div id="conseqRiskOnsetEdit_possib"></div>
                                </div>
                                <button id="addMoreEdit-conseq_risk" data-target="conseq_possibEdit"
                                    class="btn btn-secondary addMoreEditPossibilities-button mb-3">Добавить еще
                                    последствия</button>

                                <div id="countering_possibEdit-inputs" class="form-group mb-3">
                                    <label>Противодействие возможности</label>
                                    <div id="counteringRiskEdit_possib"></div>
                                </div>
                                <button id="addMoreEdit-countering_risk" data-target="countering_possibEdit"
                                    class="btn btn-secondary addMoreEditPossibilities-button mb-3">Добавить еще
                                    противодействие</button>

                                <div class="form-group mb-3">
                                    <label for="termEdit_possib">Срок</label>
                                    <input type="text" class="form-control" name="term" id="termEdit_possib"
                                        placeholder="Введите срок">
                                </div>

                                <div id="measures_possibEdit-inputs" class="form-group mb-3">
                                    <label>Мероприятия при осуществлении возможности</label>
                                    <div id="riskManagMeasuresEdit_possib"></div>
                                </div>
                                <button id="addMoreEdit-measures_risk" data-target="measures_possibEdit"
                                    class="btn btn-secondary addMoreEditPossibilities-button mb-3">Добавить еще
                                    мероприятия</button>

                            </div>
                            {{-- Кнопки --}}
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Сохранить</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Модальное окно уведомление подтверждение об удалении записи --}}
            <div class="modal fade" id="confirmationModal_Possibilities" tabindex="-1" role="dialog"
                aria-labelledby="confirmationModal_PossibilitiesLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModal_PossibilitiesLabel">Подтверждение действия</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Вы уверены что хотите удалить возможность "{{ $item->nameRisk }}"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-danger"
                                id="confirmDelete_Possibilities">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
        @endif

    </div>



    {{-- СКРИПТЫ ДЛЯ РИСКОВ --}}
    <script>
        // таблица DataTable
        $(document).ready(function() {
            $('.table').DataTable({
                responsive: true,
                columnDefs: [{
                        width: "4%",
                        targets: 0
                    },
                    {
                        width: "16%",
                        targets: 0
                    },
                    {
                        width: "16%",
                        targets: 0
                    },
                    {
                        width: "16%",
                        targets: 0
                    },
                    {
                        width: "16%",
                        targets: 0
                    },
                    {
                        width: "16%",
                        targets: 0
                    },
                    {
                        width: "16%",
                        targets: 0
                    }
                ],
                pageLength: 3,
                lengthMenu: [3, 15, 25, 35, 100, -1],
                language: {
                    search: 'Поиск:',
                    info: 'Показано с _START_ по _END_ из _TOTAL_ записей',
                    infoEmpty: 'Показано с 0 по 0 из 0 записей',
                    infoFiltered: '(отфильтровано из _MAX_ записей)',
                    lengthMenu: 'Показать _MENU_ записей',
                    paginate: {
                        next: 'Следующая',
                        previous: 'Предыдущая',
                    },
                },
                initComplete: function() {
                    var select = $('select[name="baseRisksTable_length"]');
                    select.find('option[value="-1"]').text('Все');
                },
            });
        });

        //Доп.строки
        $(document).ready(function() {
            // индесы для каждого из разделов
            let indices = {
                reason_risk: 1,
                conseq_risk: 1,
                countering_risk: 1,
                measures_risk: 1
            };
            /* при нажатии на кнопки определяем какой у нас target и взависимости от него добавляет HTML, 
               возвращенный функцией getHtml, в соответствующую секцию */
            $(".addMore-button").click(function(event) {
                event.preventDefault();
                const target = $(this).data("target");
                console.log(`Clicked on ${target} button`);
                $(`#${target}-inputs`).append(getHtml(target, indices[target]));
                indices[target]++;
            });

            // функция возвращающая html в секцию
            function getHtml(target, index) {
                let removeButton =
                    `<button class="btn btn-danger remove-btn" data-index="${index}" data-target="${target}">Удалить</button>`;

                switch (target) {
                    case 'reason_risk':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="reason_risk[${index}][reasonRisk]" placeholder="Введите причину риска">
                        ${removeButton}
                    </div>`;
                    case 'conseq_risk':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="conseq_risk[${index}][conseqRiskOnset]" placeholder="Введите последствия наступления риска">
                        ${removeButton}
                    </div>`;
                    case 'countering_risk':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="countering_risk[${index}][counteringRisk]" placeholder="Введите противодействие риску">
                        ${removeButton}
                    </div>`;
                    case 'measures_risk':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="measures_risk[${index}][riskManagMeasures]" placeholder="Введите мероприятия при осуществлении риска">
                        ${removeButton}
                    </div>`;
                    default:
                        return ''; // В случае неизвестного target возвращаем пустую строку
                }
            }
            $(document).on('click', '.remove-btn', function(e) {
                e.preventDefault();
                let target = $(this).data('target');
                let index = $(this).data('index');
                $(`[data-target=${target}][data-index=${index}]`).remove();
            });
        });

        // Подтверждение удаления
        $(document).ready(function() {
            let itemIdToDelete;
            $('#confirmationModal').on('show.bs.modal', function(event) {
                itemIdToDelete = $(event.relatedTarget).data('id');
            });
            $('#confirmDelete').click(function() {
                $.ajax({
                    method: 'GET',
                    url: `/base-risks/baseRisks-delete/${itemIdToDelete}`,
                    success: function(data) {
                        toastr.success('Запись была удалена', 'Успешно');
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);

                    },
                    error: function(error) {
                        toastr.error('Ошибка удаления', 'Ошибка');
                    }
                });
                $('#confirmationModal').modal('hide');
            });
        });

        // вывод значений записи для редактирования
        $(document).ready(function() {
            $('.editProduct').click(function() {
                var itemId = $(this).data('id');
                var itemData = $('[data-id="' + itemId + '"]');

                $('#editItemId').val(itemId);
                $('#editBaseRisksForm').attr('action', '/base-risks/baseRisks-update/' + itemId);

                $('#nameRiskEdit').val(itemData.find('[data-label="nameRisk"]').text());
                $('#termEdit').val(itemData.find('[data-label="term"]').text());

                var reasonRiskInputs = '';
                itemData.find('[data-label="reasonRisk"] li').each(function(index) {
                    reasonRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="reason_risk_edit[]" value="' +
                        $(this).text() + '" placeholder="Введите причину риска">';
                });
                $('#reasonRiskEdit').html(reasonRiskInputs);

                var conseqRiskInputs = '';
                itemData.find('[data-label="conseqRiskOnset"] li').each(function(index) {
                    conseqRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="conseq_risk_edit[]" value="' +
                        $(this).text() + '" placeholder="Введите последствия наступления риска">';
                });
                $('#conseqRiskOnsetEdit').html(conseqRiskInputs);

                var counteringRiskInputs = '';
                itemData.find('[data-label="counteringRisk"] li').each(function(index) {
                    counteringRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="countering_risk_edit[]" value="' +
                        $(this).text() + '" placeholder="Введите противодействие риску">';
                });
                $('#counteringRiskEdit').html(counteringRiskInputs);

                var measuresRiskInputs = '';
                itemData.find('[data-label="riskManagMeasures"] li').each(function(index) {
                    measuresRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="measures_risk_edit[]" value="' +
                        $(this).text() +
                        '" placeholder="Введите мероприятия при осуществлении риска">';
                });
                $('#riskManagMeasuresEdit').html(measuresRiskInputs);

                $('#editBaseRisks').modal('show');
            });
        });

        // добавление доп. строк для редактирования
        $(document).ready(function() {
            // индексы для каждого из разделов
            let indices = {
                reason_riskEdit: 1,
                conseq_riskEdit: 1,
                countering_riskEdit: 1,
                measures_riskEdit: 1
            };

            $(".addMoreEdit-button").click(function(event) {
                event.preventDefault();
                const target = $(this).data("target");

                // Изменение этой строки для добавления нового поля в блок
                $(`#${target}-inputs`).append(getHtml(target, indices[target]));
                indices[target]++;
            });


            function getHtml(target, index) {
                let removeButton =
                    `<button class="btn btn-danger removeEdit-btn" data-index="${index}" data-target="${target}">Удалить</button>`;

                switch (target) {
                    case 'reason_riskEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="reason_risk_edit[]" placeholder="Введите причину риска">
                        ${removeButton}
                    </div>`;

                    case 'conseq_riskEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="conseq_risk_edit[]" placeholder="Введите последствия наступления риска">
                        ${removeButton}
                    </div>`;
                    case 'countering_riskEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="countering_risk_edit[]" placeholder="Введите противодействие риску">
                        ${removeButton}
                    </div>`;
                    case 'measures_riskEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                        <input type="text" class="form-control mb-2" name="measures_risk_edit[]" placeholder="Введите мероприятия при осуществлении риска">
                        ${removeButton}
                    </div>`;
                    default:
                        return ''; // В случае неизвестного target возвращаем пустую строку
                }
            }

            $(document).on('click', '.removeEdit-btn', function(e) {
                e.preventDefault();
                let target = $(this).data('target');
                let index = $(this).data('index');
                $(`[data-target=${target}][data-index=${index}]`).remove();
            });

            $('#submitButton').click(function() {
                let formData = {
                    reason_riskEdit: collectFormData('reason_riskEdit'),
                    conseq_riskEdit: collectFormData('conseq_riskEdit'),
                    countering_riskEdit: collectFormData('countering_riskEdit'),
                    measures_riskEdit: collectFormData('measures_riskEdit')
                };

                let jsonData = JSON.stringify(formData);
                $('#jsonData').val(jsonData);
            });

            function collectFormData(target) {
                let dataArray = [];

                $(`[data-target=${target}] input`).each(function() {
                    let value = $(this).val();
                    if (value.trim() !== '') {
                        let dataObject = {};
                        dataObject[target] = value;
                        dataArray.push(dataObject);
                    }
                });

                return dataArray;
            }
        });
    </script>



    {{-- СКРИПТЫ ДЛЯ ВОЗМОЖНОСТЕЙ --}}
    <script>
        //Доп.строки
        $(document).ready(function() {
            // индесы для каждого из разделов
            let indices = {
                reason_possib: 1,
                conseq_possib: 1,
                countering_possib: 1,
                measures_possib: 1
            };
            /* при нажатии на кнопки определяем какой у нас target и взависимости от него добавляет HTML, 
               возвращенный функцией getHtml, в соответствующую секцию */
            $(".addMorePossibilities-button").click(function(event) {
                event.preventDefault();
                const target = $(this).data("target");
                console.log(`Clicked on ${target} button`);

                $(`#${target}-inputs`).append(getHtml(target, indices[target]));
                indices[target]++;
            });

            // функция возвращающая html в секцию
            function getHtml(target, index) {
                let removeButton =
                    `<button class="btn btn-danger remove-btn" data-index="${index}" data-target="${target}">Удалить</button>`;

                switch (target) {
                    case 'reason_possib':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="reason_risk[${index}][reasonRisk]" placeholder="Введите причину возможности">
                    ${removeButton}
                </div>`;
                    case 'conseq_possib':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="conseq_risk[${index}][conseqRiskOnset]" placeholder="Введите последствия наступления возможности">
                    ${removeButton}
                </div>`;
                    case 'countering_possib':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="countering_risk[${index}][counteringRisk]" placeholder="Введите противодействие возможности">
                    ${removeButton}
                </div>`;
                    case 'measures_possib':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="measures_risk[${index}][riskManagMeasures]" placeholder="Введите мероприятия при осуществлении возможности">
                    ${removeButton}
                </div>`;
                    default:
                        return ''; // В случае неизвестного target возвращаем пустую строку
                }
            }
            $(document).on('click', '.remove-btn', function(e) {
                e.preventDefault();
                let target = $(this).data('target');
                let index = $(this).data('index');
                console.log(`Removing ${target} at index ${index}`);
                $(`[data-target=${target}][data-index=${index}]`).remove();
            });
        });

        // Подтверждение удаления
        $(document).ready(function() {
            let itemIdToDelete;
            $('#confirmationModal_Possibilities').on('show.bs.modal', function(event) {
                itemIdToDelete = $(event.relatedTarget).data('id');
            });
            $('#confirmDelete_Possibilities').click(function() {
                $.ajax({
                    method: 'GET',
                    url: `/base-risks/basePossibilities-delete/${itemIdToDelete}`,
                    success: function(data) {
                        toastr.success('Запись была удалена', 'Успешно');
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 2000);

                    },
                    error: function(error) {
                        toastr.error('Ошибка удаления', 'Ошибка');
                    }
                });
                $('#confirmationModal_Possibilities').modal('hide');
            });
        });

        // вывод значений записи для редактирования возможности
        $(document).ready(function() {
            $(document).on('click', '.editPossibilities', function() {
                var itemId_possib = $(this).data('id');
                var itemData_possib = $('[data-id="' + itemId_possib + '"]');

                console.log('itemData_possib:', itemData_possib);

                $('#editItemId_possib').val(itemId_possib);
                $('#editBasePossibilitiesForm').attr('action', '/base-risks/basePossibilities-update/' +
                    itemId_possib);

                $('#nameRiskEdit_possib').val(itemData_possib.find('[data-label="nameRiskEdit_possib"]')
                    .text());
                $('#termEdit_possib').val(itemData_possib.find('[data-label="termEdit_possib"]').text());

                var reasonRiskInputs = '';
                itemData_possib.find('[data-label="reasonRisk_possib"] li').each(function(index) {
                    reasonRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="reason_risk_edit[]" value="' +
                        $(this).text() + '" placeholder="Введите причину возможности">';
                });
                $('#reasonRiskEdit_possib').html(reasonRiskInputs);

                var conseqRiskInputs = '';
                itemData_possib.find('[data-label="conseqRiskOnset_possib"] li').each(function(index) {
                    conseqRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="conseq_risk_edit[]" value="' +
                        $(this).text() +
                        '" placeholder="Введите последствия наступления возможности">';
                });
                $('#conseqRiskOnsetEdit_possib').html(conseqRiskInputs);

                var counteringRiskInputs = '';
                itemData_possib.find('[data-label="counteringRisk_possib"] li').each(function(index) {
                    counteringRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="countering_risk_edit[]" value="' +
                        $(this).text() +
                        '" placeholder="Введите мероприятия в отношении возникновения возможностей">';
                });
                $('#counteringRiskEdit_possib').html(counteringRiskInputs);

                var measuresRiskInputs = '';
                itemData_possib.find('[data-label="riskManagMeasures_possib"] li').each(function(index) {
                    measuresRiskInputs +=
                        '<input type="text" class="form-control mb-2" name="measures_risk_edit[]" value="' +
                        $(this).text() +
                        '" placeholder="Введите мероприятия при осуществлении возможности">';
                });
                $('#riskManagMeasuresEdit_possib').html(measuresRiskInputs);

                $('#editBasePossibilities').modal('show');
            });
        });

        // добавление доп. строк для редактирования
        $(document).ready(function() {
            // индексы для каждого из разделов
            let indices = {
                reason_possibEdit: 1,
                conseq_possibEdit: 1,
                countering_possibEdit: 1,
                measures_possibEdit: 1
            };

            $(".addMoreEditPossibilities-button").click(function(event) {
                event.preventDefault();
                const target = $(this).data("target");

                // Изменение этой строки для добавления нового поля в блок
                $(`#${target}-inputs`).append(getHtml(target, indices[target]));
                indices[target]++;
            });


            function getHtml(target, index) {
                let removeButton =
                    `<button class="btn btn-danger removeEditPossibilities-btn" data-index="${index}" data-target="${target}">Удалить</button>`;

                switch (target) {
                    case 'reason_possibEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="reason_risk_edit[]" placeholder="Введите причину возможности">
                    ${removeButton}
                </div>`;

                    case 'conseq_possibEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="conseq_risk_edit[]" placeholder="Введите последствия наступления возможности">
                    ${removeButton}
                </div>`;
                    case 'countering_possibEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="countering_risk_edit[]" placeholder="Введите мероприятия в отношении возникновения возможностей">
                    ${removeButton}
                </div>`;
                    case 'measures_possibEdit':
                        return `<div class="mb-3 block" data-target="${target}" data-index="${index}">
                    <input type="text" class="form-control mb-2" name="measures_risk_edit[]" placeholder="Введите мероприятия при осуществлении возможности">
                    ${removeButton}
                </div>`;
                    default:
                        return ''; // В случае неизвестного target возвращаем пустую строку
                }
            }

            $(document).on('click', '.removeEditPossibilities-btn', function(e) {
                e.preventDefault();
                let target = $(this).data('target');
                let index = $(this).data('index');
                $(`[data-target=${target}][data-index=${index}]`).remove();
            });

            $('#submitButtonPossibilities').click(function() {
                let formData = {
                    reason_riskEdit: collectFormData('reason_riskEdit'),
                    conseq_riskEdit: collectFormData('conseq_riskEdit'),
                    countering_riskEdit: collectFormData('countering_riskEdit'),
                    measures_riskEdit: collectFormData('measures_riskEdit')
                };

                let jsonData = JSON.stringify(formData);
                $('#jsonData').val(jsonData);
            });

            function collectFormData(target) {
                let dataArray = [];

                $(`[data-target=${target}] input`).each(function() {
                    let value = $(this).val();
                    if (value.trim() !== '') {
                        let dataObject = {};
                        dataObject[target] = value;
                        dataArray.push(dataObject);
                    }
                });

                return dataArray;
            }
        });
    </script>
@endsection
