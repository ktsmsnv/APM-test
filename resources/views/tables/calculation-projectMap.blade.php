@if (
    $project->equipment()->exists() &&
        $project->equipment->first() &&
        $project->expenses()->exists() &&
        $project->expenses->first())

    <a href="#" data-bs-toggle="modal" data-bs-target="#offerModal" class="btn btn-lg btn-primary mb-4">
        Сформировать КП
    </a>

    <div class="accordion calculation" id="accordionCalculation">
        <div class="accordion-item">
            <h2 class="accordion-header" id="calculation-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#calculation-collapseOne" aria-expanded="true"
                    aria-controls="calculation-collapseOne">
                    I Общая информация по проекту
                </button>
            </h2>
            <div id="calculation-collapseOne" class="accordion-collapse collapse show"
                aria-labelledby="calculation-headingOne">
                <div class="accordion-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex gap-3">
                            <p>Номер проекта по реестру:</p>
                            <span>{{ $project->projNum }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Руководитель проекта:</p>
                            <span>{{ $project->projManager }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Головная компания:</p>
                            <span>{{ $project->objectName }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Конечный заказчик:</p>
                            <span>{{ $project->endCustomer }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Контрагент:</p>
                            <span>{{ $project->contractor }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Дата поступления заявки:</p>
                            <span>{{ $project->date_application }}</span>
                        </div>
                        {{-- <div class="d-flex gap-3">
                        <p>Дата подачи предложения:</p>
                        <span>{{ $project->date_offer }}</span>
                            </div> --}}
                        <h6 class="mt-4 mb-3">Виды работ:</h6>
                        <div class="d-flex gap-5">
                            @if ($project->delivery)
                                <li>Поставка</li>
                            @endif

                            @if ($project->pir)
                                <li>ПИР</li>
                            @endif

                            @if ($project->kd)
                                <li>КД</li>
                            @endif

                            @if ($project->production)
                                <li>Производство</li>
                            @endif

                            @if ($project->smr)
                                <li>ШМР</li>
                            @endif

                            @if ($project->pnr)
                                <li>ПНР</li>
                            @endif

                            @if ($project->po)
                                <li>ПО</li>
                            @endif

                            @if ($project->cmr)
                                <li>СМР</li>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2">
                        <h4 class="text-center mb-3">Контакт-лист</h4>
                        <table id="markups-contacts-datatable" class="display nowrap projMap" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th>№</th> --}}
                                    <th>ФИО</th>
                                    <th>Должность</th>
                                    <th>Организация</th>
                                    <th>Зона ответственности</th>
                                    <th>Телефон</th>
                                    <th>Эл.почта</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($project->contacts->count() > 0)
                                    @foreach ($project->contacts as $index => $contact)
                                        <tr>
                                            <td>{{ $contact->fio ?? '-' }}</td>
                                            <td>{{ $contact->post ?? '-' }}</td>
                                            <td>{{ $contact->organization ?? '-' }}</td>
                                            <td>{{ $contact->responsibility ?? '-' }}</td>
                                            <td>{{ $contact->phone ?? '-' }}</td>
                                            <td>{{ $contact->email ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Нет данных</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="equipment-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#equipment-collapseTwo" aria-expanded="false" aria-controls="equipment-collapseTwo">
                    II Себестоимость оборудования
                </button>
            </h2>
            <div id="equipment-collapseTwo" class="accordion-collapse collapse" aria-labelledby="equipment-headingTwo">
                <div class="accordion-body">
                    @if ($project->equipment->count() > 0)
                        <table id="equipment-datatable" class="display nowrap projMap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Наименование ТМЦ</th>
                                    <th>Производитель</th>
                                    <th>Ед. изм.</th>
                                    <th>Кол-во</th>
                                    <th>Цена за ед. (руб. без НДС)</th>
                                    <th>Стоимость (руб. без НДС)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->equipment as $item)
                                    <tr>
                                        <td>{{ $item->nameTMC ?? '-'}}</td>
                                        <td>{{ $item->manufacture ?? '-'}}</td>
                                        <td>{{ $item->unit ?? '-'}}</td>
                                        <td>{{ $item->count ?? '-'}}</td>
                                        <td>{{ $item->priceUnit ?? '-'}}</td>
                                        {{-- <td class="total-equipment">{{ $item->count * $item->priceUnit }}</td> --}}
                                        <td class="total-equipment">{{ $item->price ?? '-'}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-align-right">Всего</th>
                                    <th id="equipment-footer"></th>
                            </tfoot>
                        </table>
                    @else
                        <h4>Нет данных для отображения</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="calculation-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#calculation-collapseThree" aria-expanded="false"
                    aria-controls="calculation-collapseThree">
                    III Прочие расходы (руб. без НДС)
                </button>
            </h2>
            <div id="calculation-collapseThree" class="accordion-collapse collapse"
                aria-labelledby="calculation-headingThree">
                <div class="accordion-body">
                    @if ($project->expenses->count() > 0)
                        <table id="expenses-datatable" class="display nowrap projMap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Наименование</th>
                                    <th>Стоимость (руб. без НДС)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->expenses as $index => $expense)
                                    <tr>
                                        <td>Командировочные</td>
                                        <td>{{ $expense->commandir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>РД</td>
                                        <td>{{ $expense->rd ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>ШМР</td>
                                        <td>{{ $expense->shmr ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>ПНР</td>
                                        <td>{{ $expense->pnr ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Сертификаты</td>
                                        <td>{{ $expense->cert ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Доставка/Логистика</td>
                                        <td>{{ $expense->delivery ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Растаможка</td>
                                        <td>{{ $expense->rastam ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Разработка ППО</td>
                                        <td>{{ $expense->ppo ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Банковская гарантия</td>
                                        <td>{{ $expense->guarantee ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Поверка</td>
                                        <td>{{ $expense->check ?? '-' }}</td>
                                    </tr>
                                    <!-- Добавляем отдельные строки для каждого дополнительного расхода -->
                                    @foreach ($expense->additionalExpenses as $additionalExpense)
                                        <tr>
                                            <td>Дополнительный расход</td>
                                            <td>{{ $additionalExpense->cost }}</td>
                                        </tr>
                                    @endforeach
                                    <!-- Конец цикла для дополнительных расходов -->
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th class="text-align-right">Всего</th>
                                    <th>{{ $expense->total }}</th>
                                </tr>
                            </tfoot> --}}
                            @if ($project->expenses->isNotEmpty() && $project->expenses->first()->total)
                                <tfoot>
                                    <tr>
                                        <th class="text-align-right">Всего</th>
                                        <th>{{ $project->expenses->first()->total }}</th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    @else
                        <table id="expenses-datatable" class="display nowrap projMap" style="width:100%">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center">Нет данных</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="calculation-headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#calculation-collapseFour" aria-expanded="false"
                    aria-controls="calculation-collapseFour">
                    IV КСГ
                </button>
            </h2>
            <div id="calculation-collapseFour" class="accordion-collapse collapse"
                aria-labelledby="calculation-headingFour">
                <div class="accordion-body">
                    @if ($project->totals->count() > 0)
                        @foreach ($project->totals as $totals)
                            <div class="d-flex gap-3">
                                <p>Разработка РКД (дн.):</p>
                                <span>{{ $totals['kdDays'] ?? '-'}}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Комплектация (дн.):</p>
                                <span>{{ $totals['equipmentDays'] ?? '-'}}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Производство (дн.):</p>
                                <span>{{ $totals['productionDays'] ?? '-'}}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Доставка (дн.):</p>
                                <span>{{ $totals['shipmentDays'] ?? '-'}}</span>
                            </div>
                            <div class="d-flex gap-4">
                                <div class="d-flex gap-3">
                                    <p>Итого срок реализации (дн.)</p>
                                    <span>{{ $totals['periodDays'] ?? '-'}}</span>
                                </div>
                                <div class="d-flex gap-3">
                                    <p>Себестоимость (руб. без НДС)</p>
                                    <span>{{ $totals['price'] ?? '-'}}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4>Нет данных</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="calculation-headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#calculation-collapseFive" aria-expanded="false"
                    aria-controls="calculation-collapseFive">
                    V Уровень наценки
                </button>
            </h2>
            <div id="calculation-collapseFive" class="accordion-collapse collapse"
                aria-labelledby="calculation-headingFive">
                <div class="accordion-body">
                    @if ($project->markups->count() > 0)
                        <table id="markups-datatable" class="display nowrap projMap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>% наценки</th>
                                    <th>Сумма подачи ТКП в руб. без НДС</th>
                                    <th>С кем согласовано (Фамилия И.О.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->markups as $index => $markup)
                                    <tr>
                                        <td>{{ $markup->date ?? '-'}}</td>
                                        <td>{{ $markup->percentage ?? '-'}}</td>
                                        <td>{{ $markup->priceSubTkp ?? '-'}}</td>
                                        <td>{{ $markup->agreedFio ?? '-'}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h4>Нет данных</h4>
                    @endif

                    <div class="mt-5">
                        <h4 class="text-center mb-3">Риски</h4>
                        @if ($project->calc_risks)
                            @if ($project->calc_risks->count() > 0)
                                <table id="markups-risks-datatable" class="display nowrap projMap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Наименование риска</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project->calc_risks as $index => $risk)
                                            <tr>
                                                <td>{{ $risk->calcRisk_name ?? '-'}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h4>Нет данных </h4>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-3 mt-5">
        <a href="{{ route('project-map-update', ['id' => $project->id, 'tab' => 'calculation']) }}">
            <button class="btn btn-primary">Редактировать</button>
        </a>
        {{-- <a href="{{ route('project-map-delete', $project->id) }}"><button class="btn btn-danger">Удалить</button></a> --}}
    </div>
@else
    <div class="btns d-flex gap-4 mb-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#addContinueModal" class="btn btn-lg btn-danger">
            Продолжить заполнение расчета
        </a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#offerModal" class="btn btn-lg btn-primary">
            Сформировать КП
        </a>
    </div>
    <div class="accordion calculation" id="accordionCalculation">
        <div class="accordion-item">
            <h2 class="accordion-header" id="calculation-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#calculation-collapseOne" aria-expanded="true"
                    aria-controls="calculation-collapseOne">
                    I Общая информация по проекту
                </button>
            </h2>
            <div id="calculation-collapseOne" class="accordion-collapse collapse show"
                aria-labelledby="calculation-headingOne">
                <div class="accordion-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex gap-3">
                            <p>Номер проекта по реестру:</p>
                            <span>{{ $project->projNum }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Руководитель проекта:</p>
                            <span>{{ $project->projManager }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Головная компания:</p>
                            <span>{{ $project->objectName }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Конечный заказчик:</p>
                            <span>{{ $project->endCustomer }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Контрагент:</p>
                            <span>{{ $project->contractor }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <p>Дата поступления заявки:</p>
                            <span>{{ $project->date_application }}</span>
                        </div>
                        {{-- <div class="d-flex gap-3">
                            <p>Дата подачи предложения:</p>
                            <span>{{ $project->date_offer }}</span>
                        </div> --}}
                        <h6 class="mt-4 mb-3">Виды работ:</h6>
                        <div class="d-flex gap-5">
                            @if ($project->delivery)
                                <li>Поставка</li>
                            @endif

                            @if ($project->pir)
                                <li>ПИР</li>
                            @endif

                            @if ($project->kd)
                                <li>КД</li>
                            @endif

                            @if ($project->production)
                                <li>Производство</li>
                            @endif

                            @if ($project->smr)
                                <li>ШМР</li>
                            @endif

                            @if ($project->pnr)
                                <li>ПНР</li>
                            @endif

                            @if ($project->po)
                                <li>ПО</li>
                            @endif

                            @if ($project->cmr)
                                <li>СМР</li>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2">
                        <h4 class="text-center mb-3">Контакт-лист</h4>
                        <table id="markups-contacts-datatable" class="display nowrap projMap" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th>№</th> --}}
                                    <th>ФИО</th>
                                    <th>Должность</th>
                                    <th>Организация</th>
                                    <th>Зона ответственности</th>
                                    <th>Телефон</th>
                                    <th>Эл.почта</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($project->contacts->count() > 0)
                                    @foreach ($project->contacts as $index => $contact)
                                        <tr>
                                            {{-- <td>{{ $contact->id }}</td> --}}
                                            <td>{{ $contact->fio }}</td>
                                            <td>{{ $contact->post }}</td>
                                            <td>{{ $contact->organization }}</td>
                                            <td>{{ $contact->responsibility }}</td>
                                            <td>{{ $contact->phone }}</td>
                                            <td>{{ $contact->email }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif


<script>
    $(document).ready(function() {
        var values = $('.total-equipment');
        var total = 0;
        values.each(function() {
            var value = parseFloat($(this).text().replace(',', '.'));
            // console.log('Value:', value, 'Type:', typeof value);
            if (!isNaN(value)) {
                total += value;
            }
        });
        $('#equipment-footer').text(total.toFixed(2));
        // Обработчик изменений в поле выбора "Наименование риска"
        $('#risk_name').change(function() {
            // Очищаем списки
            $('#reasonList').empty();
            $('#consequenceList').empty();
            $('#counteringRiskList').empty();
            $('#riskManagMeasuresList').empty();

            // Получаем выбранное значение
            var selectedOption = $(this).find(':selected');
            var selectedRisk = selectedOption.val();

            // Запрос на сервер для получения данных по выбранному риску
            $.ajax({
                url: '/getRiskData',
                method: 'GET',
                data: {
                    risk: selectedRisk
                },
                success: function(response) {
                    // Обновляем переменные и отображаем данные
                    response.reasonData.forEach(function(reason, index) {
                        $('#reasonList').append(
                            '<li class="mb-3"><input type="text" class="input_editable" required readonly name="risk_reason[' +
                            index + '][reasonRisk]" value="' + reason
                            .reasonRisk + '"</li>');
                    });

                    response.consequenceData.forEach((consequence, index) => {
                        $('#consequenceList').append(
                            '<li class="mb-3"><input type="text" class="input_editable" required readonly name="risk_consequences[' +
                            index + '][conseqRiskOnset]" value="' + consequence
                            .conseqRiskOnset + '"</li>');
                    });

                    if (Array.isArray(response.counteringRiskData)) {
                        response.counteringRiskData.forEach(function(counteringRisk,
                            index) {
                            $('#counteringRiskList').append(
                                '<li class="mb-3"><input type="text" class="input_editable" required readonly name="risk_counteraction[' +
                                index + '][counteringRisk]" value="' +
                                counteringRisk.counteringRisk + '"</li>');
                        });
                    }

                    if (Array.isArray(response.riskManagMeasuresData)) {
                        response.riskManagMeasuresData.forEach(function(measure, index) {
                            if (typeof measure === 'object') {
                                // Если это объект, выведите свойства объекта
                                for (var prop in measure) {
                                    if (measure.hasOwnProperty(prop)) {
                                        $('#riskManagMeasuresList').append(
                                            '<li class="mb-3"><input type="text" class="input_editable" required readonly name="risk_measures[' +
                                            index +
                                            '][riskManagMeasures]" value="' +
                                            measure[prop] + '"</li>');
                                    }
                                }
                            } else {
                                // В противном случае просто выведите значение
                                $('#riskManagMeasuresList').append('<li>' +
                                    measure + '</li>');
                            }
                        });
                    }

                    // Устанавливаем значение поля "Срок" из базы данных
                    $('#termList').val(response.term);
                },
                error: function(error) {
                    console.error('Error fetching risk data:', error);
                }
            });
        });
        // Подтверждение удаления
        let itemIdToDelete;
        $('#confirmationModal').on('show.bs.modal', function(event) {
            itemIdToDelete = $(event.relatedTarget).data('id');
            projId = $(".modalId").data('id');
        });
        $('#confirmDelete').click(function() {
            $.ajax({
                method: 'GET',
                url: `/project-maps/risk-delete/${itemIdToDelete}`,
                success: function(data) {
                    toastr.success('Запись была удалена', 'Успешно');
                    let projectId = data.projectId;
                    setTimeout(function() {
                        window.location.href = `/project-maps/all/${projId}/#risks`;
                    }, 1000);
                },
                error: function(error) {
                    if (error.responseText) {
                        toastr.error(error.responseText, 'Ошибка');
                    } else {
                        toastr.error('Ошибка удаления', 'Ошибка');
                    }
                }
            });
            $('#confirmationModal').modal('hide');
        });
        // Обязательные поля ввода
        function validateAndSubmit() {
            // Удаление предыдущих стилей ошибок
            $('.required-field').removeClass('required-field');
            $('.error-message').remove();

            // Проверка каждого обязательного поля
            $('#dependentFields :input[required]').each(function() {
                const fieldValue = $(this).val();
                if (!fieldValue.trim()) {
                    // Выделение пустого поля красной рамкой
                    $(this).addClass('required-field');

                    // Отображение сообщения об ошибке
                    const errorMessage = $(
                        '<div class="error-message">Обязательное поле для заполнения</div>');
                    $(this).parent().append(errorMessage);
                }
            });
        }
        // Привязка функции validateAndSubmit к событию клика кнопки отправки
        $('#submitBtn').click(function() {
            // console.log('Button clicked!');
            validateAndSubmit();
        });
    });

    $(document).ready(function() {
        // индесы для каждого из разделов
        let indices = {
            equipment: 1,
            markups: 1,
            contacts: 1,
            expenses: 1,
            risks: 1
        };

        /* при нажатии на кнопки определяем какой у нас target и в зависимости от него добавляет HTML,
           возвращенный функцией getHtml, в соответствующую секцию */
        $(".modal-content").on("click", ".addMore-button", function(event) {
            event.preventDefault();
            const target = $(this).data("target");

            // Добавление новой строки
            // $(`#${target}-inputs`).append(getHtml(target, indices[target]));
            // indices[target]++;
            // Проверяем, существует ли уже элемент с этим индексом
            if ($(`#${target}-inputs [data-index=${indices[target]}]`).length === 0) {
                // Добавление новой строки
                $(`#${target}-inputs`).append(getHtml(target, indices[target]));
            }
            indices[target]++;
        });
    });

    // функция возвращающая html в секцию
    function getHtml(target, index) {
        let removeButton =
            `<button class="btn btn-danger remove-btn" data-index="${index}" data-target="${target}">Удалить</button>`;
        switch (target) {
            case 'equipment':
                return `<tr data-target="${target}" data-index="${index}">
                        <td><input type="text" class="form-control" name="equipment[${index}][nameTMC]" id="nameTMC"
                                placeholder="Введите наименование ТМЦ"></td>
                        <td> <input type="text" class="form-control" name="equipment[${index}][manufacture]" id="manufacture"
                            placeholder="Введите производителя"></td>
                        <td><input type="text" class="form-control" name="equipment[${index}][unit]" id="unit"
                            placeholder="Введите ед.изм."></td>
                        <td> <input type="text" class="form-control" name="equipment[${index}][count]" id="count"
                            placeholder="Введите количество"></td>
                        <td><input type="text" class="form-control" name="equipment[${index}][priceUnit]" id="priceUnit"
                            placeholder="Введите цену за ед."></td>
                        <td style="border:none;">${removeButton} </td>
                    </tr>`;
            case 'markups':
                return `<div class="mb-3 block" data-target="${target}" data-index="${index}">---
                        <div class="form-group mb-3">
                            <label for="date">Дата:</label>
                            <input type="date" class="form-control" name="markups[${index}][date]" id="date"
                                placeholder="Выберите дату">
                        </div>
                        <div class="form-group mb-3">
                            <label for="percentage">% наценки:</label>
                            <input type="text" class="form-control" name="markups[${index}][percentage]" id="percentage"
                                placeholder="Введитепроцент наценки">
                        </div>
                        <div class="form-group mb-3">
                            <label for="priceSubTkp">Сумма подачи ТКП в руб. без НДС:</label>
                            <input type="text" class="form-control" name="markups[${index}][priceSubTkp]" id="priceSubTkp"
                                placeholder="Введите сумму">
                        </div>
                        <div class="form-group mb-3">
                            <label for="agreedFio">С кем согласовано (Фамилия И.О.):</label>
                            <input type="text" class="form-control" name="markups[${index}][agreedFio]" id="agreedFio"
                                placeholder="Введите ФИО">
                        </div>
                        ${removeButton}
                    </div>`;
            case 'contacts':
                return `<div class="mb-3 block" data-target="${target}" data-index="${index}">---
                        <div class="form-group mb-3">
                            <label for="fio">ФИО:</label>
                            <input type="fio" class="form-control" name="contacts[${index}][fio]" id="fio"
                                placeholder="Введите ФИО">
                        </div>
                        <div class="form-group mb-3">
                            <label for="post">Должность:</label>
                            <input type="text" class="form-control" name="contacts[${index}][post]" id="post"
                                placeholder="Введите должность">
                        </div>
                        <div class="form-group mb-3">
                            <label for="organization">Организация:</label>
                            <input type="text" class="form-control" name="contacts[${index}][organization]" id="organization"
                                placeholder="Введите организацию">
                        </div>
                        <div class="form-group mb-3">
                            <label for="responsibility">Зона ответственности:</label>
                            <input type="text" class="form-control" name="contacts[${index}][responsibility]" id="responsibility"
                                placeholder="Введите зону ответственности">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Телефон:</label>
                            <input type="text" class="form-control" name="contacts[${index}][phone]" id="phone"
                                placeholder="Введите телефон">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Эл. почта:</label>
                            <input type="text" class="form-control" name="contacts[${index}][email]" id="email"
                                placeholder="Введите эл.почту">
                        </div>
                        ${removeButton}
                    </div>`;
            case 'risks':
                return `<div class="form-group mb-3 block" data-target="${target}" data-index="${index}">---
                        <label for="riskName">Наименование риска:</label>
                        <input type="riskName" class="form-control" name="risks[${index}][riskName]" id="riskName"
                            placeholder="Введите наименование риска">
                            ${removeButton}
                    </div>`;
            case 'expenses': // Добавленный case для дополнительных расходов
                return `<div class="form-group mb-3 block" data-target="${target}" data-index="${index}">
                        <label for="additionalExpense">Дополнительный расход:</label>
                        <input type="text" class="form-control" name="additional_expenses[]" id="additionalExpense"
                            placeholder="Введите дополнительный расход">
                        ${removeButton}
                    </div>`;
        }
    }

    $(document).on('click', '.remove-btn', function(e) {
        e.preventDefault();
        let target = $(this).data('target');
        let index = $(this).data('index');
        $(`[data-target=${target}][data-index=${index}]`).remove();
    });
</script>
