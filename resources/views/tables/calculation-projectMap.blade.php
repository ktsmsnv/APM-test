<div class="accordion calculation" id="accordionCalculation">
    <div class="accordion-item">
        <h2 class="accordion-header" id="calculation-headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#calculation-collapseOne" aria-expanded="true" aria-controls="calculation-collapseOne">
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
                        <p>Наим.организатора закупки:</p>
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
                    <div class="d-flex gap-3">
                        <p>Дата подачи предложения:</p>
                        <span>{{ $project->date_offer }}</span>
                    </div>
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
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="equipment-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#equipment-collapseTwo" aria-expanded="false" aria-controls="equipment-collapseTwo">
                II Оборудование
            </button>
        </h2>
        <div id="equipment-collapseTwo" class="accordion-collapse collapse" aria-labelledby="equipment-headingTwo">
            <div class="accordion-body">
                <table id="equipment-datatable" class="display nowrap projMap" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Наименование ТМЦ</th>
                            <th>Производитель</th>
                            <th>Ед. изм.</th>
                            <th>Кол-во</th>
                            <th>Цена за ед. (руб. без НДС)</th>
                            <th>Стоимость (руб. без НДС)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($equipment as $item) --}}
                        @foreach ($project->equipment as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nameTMC }}</td>
                                <td>{{ $item->manufacture }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->count }}</td>
                                <td>{{ $item->priceUnit }}</td>
                                {{-- <td class="total-equipment">{{ $item->count * $item->priceUnit }}</td> --}}
                                <td class="total-equipment">{{ $item->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-align-right">Всего</th>
                            <th id="equipment-footer"></th>
                    </tfoot>
                </table>
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
                <table id="expenses-datatable" class="display nowrap projMap" style="width:100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Наименование</th>
                            <th>Стоимость (руб. без НДС)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($project->expenses->count() > 0)
                            @foreach ($project->expenses as $index => $expense)
                                <tr>
                                    <td>1</td>
                                    <td>Командировочные</td>
                                    <td>{{ $expense->commandir }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>РД</td>
                                    <td>{{ $expense->rd }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>ШМР</td>
                                    <td>{{ $expense->shmr }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>ПНР</td>
                                    <td>{{ $expense->pnr }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Сертификаты</td>
                                    <td>{{ $expense->cert }}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Доставка/Логистика</td>
                                    <td>{{ $expense->delivery }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Растаможка</td>
                                    <td>{{ $expense->rastam }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Разработка ППО</td>
                                    <td>{{ $expense->ppo }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Банковская гарантия</td>
                                    <td>{{ $expense->guarantee }}</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Поверка</td>
                                    <td>{{ $expense->check }}</td>
                                </tr>
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-align-right">Всего</th>
                            <th>{{ $expense->total }}</th>
                        </tr>
                    </tfoot>
                @else
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="calculation-headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#calculation-collapseFour" aria-expanded="false"
                aria-controls="calculation-collapseFour">
                IV ИТОГО
            </button>
        </h2>
        <div id="calculation-collapseFour" class="accordion-collapse collapse"
            aria-labelledby="calculation-headingFour">
            <div class="accordion-body">
                <div class="d-flex flex-column">
                    @if ($project->totals->count() > 0)
                        @foreach ($project->totals as $totals)
                            <div class="d-flex gap-3">
                                <p>Разработка РКД (дн.):</p>
                                <span>{{ $totals['kdDays'] }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Комплектация (дн.):</p>
                                <span>{{ $totals['equipmentDays'] }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Производство (дн.):</p>
                                <span>{{ $totals['productionDays'] }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Отгрузка (дн.):</p>
                                <span>{{ $totals['shipmentDays'] }}</span>
                            </div>
                            <div class="d-flex gap-4">
                                <div class="d-flex gap-3">
                                    <p>Итого срок реализации (дн.)</p>
                                    <span>{{ $totals['periodDays'] }}</span>
                                </div>
                                <div class="d-flex gap-3">
                                    <p>Себестоимость (руб. без НДС)</p>
                                    <span>{{ $totals['price'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Нет данных для отображения</p>
                    @endif
                </div>
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
                <table id="markups-datatable" class="display nowrap projMap" style="width:100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Дата</th>
                            <th>% наценки</th>
                            <th>Сумма подачи ТКП в руб. без НДС</th>
                            <th>С кем согласовано (Фамилия И.О.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($project->markups->count() > 0)
                            @foreach ($project->markups as $index => $markup)
                                <tr>
                                    <td>{{ $markup->id }}</td>
                                    <td>{{ $markup->date }}</td>
                                    <td>{{ $markup->percentage }}</td>
                                    <td>{{ $markup->priceSubTkp }}</td>
                                    <td>{{ $markup->agreedFio }}</td>
                                </tr>
                            @endforeach
                        @else
                        @endif
                    </tbody>
                </table>
                <div class="mt-5">
                    <h4 class="text-center mb-3">Контакт-лист</h4>
                    <table id="markups-contacts-datatable" class="display nowrap projMap" style="width:100%">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>ФИО</th>
                                <th>Должность/организация</th>
                                <th>Зона ответственности</th>
                                <th>Телефон/эл.почта</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($project->contacts->count() > 0)
                                @foreach ($project->contacts as $index => $contact)
                                    <tr>
                                        <td>{{ $contact->id }}</td>
                                        <td>{{ $contact->fio }}</td>
                                        <td>{{ $contact->post }}</td>
                                        <td>{{ $contact->responsibility }}</td>
                                        <td>{{ $contact->contact }}</td>
                                    </tr>
                                @endforeach
                            @else
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <h4 class="text-center mb-3">Риски</h4>
                    <table id="markups-risks-datatable" class="display nowrap projMap" style="width:100%">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Наименование риска</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($project->calc_risks)
                            @if ($project->calc_risks->count() > 0)
                                @foreach ($project->calc_risks as $index => $risk)
                                    <tr>
                                        <td>{{ $risk->id }}</td>
                                        <td>{{ $risk->calcRisk_name }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <p>Нет рисков</p>
                            @endif
                        @else
                            <p>Риски не загружаются. Ошибка</p>
                        @endif
                        </tbody>
                    </table>
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

<script>
    $(document).ready(function() {
        var values = $('.total-equipment');
        var total = 0;

        values.each(function() {
            var value = parseFloat($(this).text().replace(',', '.'));
            console.log('Value:', value, 'Type:', typeof value);
            if (!isNaN(value)) {
                total += value;
            }
        });

        $('#equipment-footer').text(total.toFixed(2));
    });


    // таблица DataTable
    $(document).ready(function() {
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
            console.log('Button clicked!');
            validateAndSubmit();
        });

    });
</script>
