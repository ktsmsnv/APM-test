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
                    <th>Наименование 111риска</th>
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
                        <td data-label="nameRisk">{{ $item->nameRisk }}</td>
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
                        <td data-label="term">{{ $item->term }}</td>
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
                                <a class="deleteProduct btn btn-xs btn-danger" data-bs-toggle="modal"
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
                            <input type="text" class="form-control" name="reason_risk[0][reasonRisk]" id="reasonRisk"
                                placeholder="Введите причину риска">
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
    <div class="modal fade" id="editBaseRisks" tabindex="-1" role="dialog" aria-labelledby="editBaseRisksLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            {{-- <form id="editBaseRisksForm" action="{{ route('baseRisks-update', ['id' => $item->id]) }}" method="post"> --}}
            <form id="editBaseRisksForm" method="post" action="">
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
                            <input type="text" class="form-control" name="term" id="term_Edit"
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            pageLength: 5,
            lengthMenu: [5, 25, 35, 45, 100, -1],
            language: {
                search: 'Поиск:',
                info: 'Показано с _START_ по _END_ из _TOTAL_ записей',
                infoEmpty: 'Показано с 0 по 0 из 0 записей',
                infoFiltered: '(отфильтровано из _MAX_ записей)',
                lengthMenu: 'Показать _MENU_ записей',
                sEmptyTable: "НЕТ ЗАПИСЕЙ В ТАБЛИЦЕ",
                paginate: {
                    next: 'Следующая',
                    previous: 'Предыдущая',
                },
            },
            initComplete: function() {
                var select = $('select[name="baseRisksTable_length"]');
                select.find('option[value="-1"]').text('Все');

                var select2 = $('select[name="basePossibilitiesTable_length"]');
                select2.find('option[value="-1"]').text('Все');
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
    // вывод значений записи для редактирования риска
    $(document).ready(function() {
        $('.editProduct').click(function(event) {
            event.preventDefault();
            var itemId = $(this).data('id');
            var modalIdRisks = '#editBaseRisks';
            var formActionRisks = '{{ route('baseRisks-update', ['id' => ':id']) }}'.replace(':id',
                itemId);

            $(modalIdRisks + ' #editItemId').val(itemId);
            $(modalIdRisks + ' #editBaseRisksForm').attr('action', formActionRisks);


            // Отправляем AJAX-запрос для получения данных из базы данных
            $.ajax({
                url: '/get-base-risk/' + itemId,
                type: 'GET',
                success: function(response) {
                    console.log(itemId);
                    $(modalIdRisks + ' #nameRiskEdit').val(response.nameRisk);
                    $(modalIdRisks + ' #term_Edit').val(response.term);

                    // Преобразуем строки JSON в массивы объектов для каждого поля
                    var reasonRiskData = JSON.parse(response.reasonRisk);
                    var conseqRiskData = JSON.parse(response.conseqRiskOnset);
                    var counteringRiskData = JSON.parse(response.counteringRisk);
                    var measuresRiskData = JSON.parse(response.riskManagMeasures);

                    // Добавляем причины риска
                    var reasonRiskInputs = '';
                    $.each(reasonRiskData, function(index, reason) {
                        reasonRiskInputs +=
                            '<input type="text" class="form-control mb-2" name="reason_risk_edit[]" value="' +
                            reason.reasonRisk +
                            '" placeholder="Введите причину риска">';
                    });
                    $(modalIdRisks + ' #reasonRiskEdit').html(reasonRiskInputs);

                    // Добавляем последствия наступления риска
                    var conseqRiskInputs = '';
                    $.each(conseqRiskData, function(index, conseq) {
                        conseqRiskInputs +=
                            '<input type="text" class="form-control mb-2" name="conseq_risk_edit[]" value="' +
                            conseq.conseqRiskOnset +
                            '" placeholder="Введите последствия наступления риска">';
                    });
                    $(modalIdRisks + ' #conseqRiskOnsetEdit').html(conseqRiskInputs);

                    // Добавляем противодействие риску
                    var counteringRiskInputs = '';
                    $.each(counteringRiskData, function(index, countering) {
                        counteringRiskInputs +=
                            '<input type="text" class="form-control mb-2" name="countering_risk_edit[]" value="' +
                            countering.counteringRisk +
                            '" placeholder="Введите противодействие риску">';
                    });
                    $(modalIdRisks + ' #counteringRiskEdit').html(counteringRiskInputs);

                    // Добавляем мероприятия при осуществлении риска
                    var measuresRiskInputs = '';
                    $.each(measuresRiskData, function(index, measure) {
                        measuresRiskInputs +=
                            '<input type="text" class="form-control mb-2" name="measures_risk_edit[]" value="' +
                            measure.riskManagMeasures +
                            '" placeholder="Введите мероприятия при осуществлении риска">';
                    });
                    $(modalIdRisks + ' #riskManagMeasuresEdit').html(measuresRiskInputs);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            $(modalIdRisks).modal('show');
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
