@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="pb-5">Добавить карту проекта</h1>
        <form action="{{ route('project-store') }}" method="post" id="addMap">
            @csrf
            <div class="d-grid gap-5 addMap__grid">
                {{-- Общая информация --}}
                <div class="project-add alert">
                    <h2>I Общая информация по проекту</h2>
                    <div class="form-group mb-3">
                        <label for="projNum">Номер проекта по реестру:</label>
                        <div class="d-flex">
                            <input type="text" class="form-control" name="projNumPre" id="projNumPre"
                                value="{{ $projectNum }}-{{ $currentYear }}" readonly>
                            <div class="form-group mb-3">
                                <input list="projNumbs" name="projNumSuf" required placeholder="Выберите тип"
                                    id="projNumSuf" />
                                <datalist id="projNumbs">
                                    <option value="СИ">
                                    <option value="ЭОБ">
                                    <option value="НХРС">
                                    <option value="КСТ">
                                </datalist>
                            </div>
                        </div>
                        <input type="hidden" name="projNum" id="projNumCombined">
                    </div>
                    <div class="form-group mb-3">
                        <label for="projManager">Руководитель проекта:</label>
                        <select class="form-control" name="projManager" id="projManager" required>
                            @foreach ($projectManagers as $manager)
                                <option value="{{ $manager->fio }}">{{ $manager->fio }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="objectName">Наименование объекта:</label>
                        <input type="text" class="form-control" name="objectName" id="objectName"
                            placeholder="Введите название объекта" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="endCustomer">Головная компания :</label>
                        <input type="text" class="form-control" name="endCustomer" id="endCustomer"
                            placeholder="Введите головную компанию">
                    </div>
                    <div class="form-group mb-3">
                        <label for="contractor">Наим.организатора закупки:</label>
                        <input type="text" class="form-control" name="contractor" id="contractor"
                            placeholder="Введите наим.организатора закупки">
                    </div>
                    <div class="form-group mb-3">
                        <label for="date_application">Дата поступления заявки:</label>
                        <input type="date" class="form-control" name="date_application" id="date_application"
                            placeholder="Выберите дату поступления заявки">
                    </div>
                    <div class="form-group mb-3">
                        <label for="date_offer">Дата подачи предложения:</label>
                        <input type="date" class="form-control" name="date_offer" id="date_offer"
                            placeholder="Выберите дату подачи предложения">
                    </div>
                    <h3 class="mt-4 mb-3">Виды работ</h3>
                    <div class="d-flex gap-5">
                        <div class="d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="delivery" id="delivery">
                                <label class="form-check-label" for="delivery">Поставка</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pir" id="pir">
                                <label class="form-check-label" for="pir">ПИР</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="kd" id="kd">
                                <label class="form-check-label" for="kd">КД</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="production" id="production">
                                <label class="form-check-label" for="production">Производство</label>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="smr" id="smr">
                                <label class="form-check-label" for="smr">ШМР</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pnr" id="pnr">
                                <label class="form-check-label" for="pnr">ПНР</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="po" id="po">
                                <label class="form-check-label" for="po">ПО</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cmr" id="cmr">
                                <label class="form-check-label" for="cmr">СМР</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Контакт лист --}}
                <div class="contacts-add alert pt-3">
                    <h4 class="text-center">Контакт лист</h4>
                    <div id="contacts-inputs">
                        <div class="mb-3">
                            <div class="form-group mb-3">
                                <label for="fio">ФИО:</label>
                                <input type="fio" class="form-control" name="contacts[0][fio]" id="fio"
                                    placeholder="Введите ФИО">
                            </div>
                            <div class="form-group mb-3">
                                <label for="post">Должность/ Организация:</label>
                                <input type="text" class="form-control" name="contacts[0][post]" id="post"
                                    placeholder="Введите должность/организацию">
                            </div>
                            <div class="form-group mb-3">
                                <label for="responsibility">Зона ответственности:</label>
                                <input type="text" class="form-control" name="contacts[0][responsibility]"
                                    id="responsibility" placeholder="Введите зону ответственности">
                            </div>
                            <div class="form-group mb-3">
                                <label for="contact">Телефон / эл. почта:</label>
                                <input type="text" class="form-control" name="contacts[0][contact]" id="contact"
                                    placeholder="Введите телефон/эл.почту">
                            </div>
                        </div>
                    </div>
                    <button id="addMore-contacts" data-target="contacts"
                        class="btn btn-secondary addMore-button">Добавить
                        еще контакт</button>
                </div>
                {{-- Оборудование --}}
                <div class="equipment-add alert pt-5">
                    <h2>II Оборудование</h2>
                    <div>
                        <div class="mb-3">
                            <table id="equipment-datatable" class="display nowrap projMap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Наименование ТМЦ</th>
                                        <th>Производитель</th>
                                        <th>Ед. изм.</th>
                                        <th>Кол-во</th>
                                        <th>Цена за ед. (руб. без НДС)</th>
                                    </tr>
                                </thead>
                                <tbody id="equipment-inputs">
                                    <tr>
                                        <td><input type="text" class="form-control" name="equipment[0][nameTMC]"
                                                id="nameTMC" placeholder="Введите наименование ТМЦ"></td>
                                        <td> <input type="text" class="form-control" name="equipment[0][manufacture]"
                                                id="manufacture" placeholder="Введите производителя"></td>
                                        <td><input type="text" class="form-control" name="equipment[0][unit]"
                                                id="unit" placeholder="Введите ед.изм."></td>
                                        <td> <input type="text" class="form-control" name="equipment[0][count]"
                                                id="count" placeholder="Введите количество"></td>
                                        <td><input type="text" class="form-control" name="equipment[0][priceUnit]"
                                                id="priceUnit" placeholder="Введите цену за ед."></td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- Стоимость расчитывается автоматически в ProjectController --}}
                            {{-- <div class="form-group mb-3">
                                <input type="text" class="form-control" name="equipment[0][price]" id="price"
                                    placeholder="Стоимость (руб. без НДС)" value="250">
                            </div> --}}
                        </div>
                    </div>
                    <button id="addMore-equipment" data-target="equipment"
                        class="btn btn-secondary addMore-button">Добавить
                        еще
                        оборудование</button>
                </div>
                {{-- Прочие расходы --}}
                <div class="expenses-add alert pt-5">
                    <h2>III Прочие расходы (руб. без НДС)</h2>
                    <div class="form-group mb-3">
                        <label for="commandir">Командировочные:</label>
                        <input type="text" class="form-control" name="commandir" id="commandir"
                            placeholder="Введите командировочные">
                    </div>
                    <div class="form-group mb-3">
                        <label for="rd">РД:</label>
                        <input type="text" class="form-control" name="rd" id="rd"
                            placeholder="Введите РД">
                    </div>
                    <div class="form-group mb-3">
                        <label for="shmr">ШМР:</label>
                        <input type="text" class="form-control" name="shmr" id="shmr"
                            placeholder="Введите ШМР">
                    </div>
                    <div class="form-group mb-3">
                        <label for="pnr">ПНР:</label>
                        <input type="text" class="form-control" name="pnr" id="pnr"
                            placeholder="Введите ПНР">
                    </div>
                    <div class="form-group mb-3">
                        <label for="cert">Сертификаты:</label>
                        <input type="text" class="form-control" name="cert" id="cert"
                            placeholder="Введите сертификаты">
                    </div>
                    <div class="form-group mb-3">
                        <label for="delivery">Доставка/ Логистика:</label>
                        <input type="text" class="form-control" name="delivery" id="delivery"
                            placeholder="Введите доставку/логистику">
                    </div>
                    <div class="form-group mb-3">
                        <label for="rastam">Растаможка:</label>
                        <input type="text" class="form-control" name="rastam" id="rastam"
                            placeholder="Введите растаможку">
                    </div>
                    <div class="form-group mb-3">
                        <label for="ppo">Разработка ППО:</label>
                        <input type="text" class="form-control" name="ppo" id="ppo"
                            placeholder="Введите разработку ППО">
                    </div>
                    <div class="form-group mb-3">
                        <label for="guarantee">Банковская гарантия:</label>
                        <input type="text" class="form-control" name="guarantee" id="guarantee"
                            placeholder="Введите банковскую гарантию">
                    </div>
                    <div class="form-group mb-3">
                        <label for="check">Поверка:</label>
                        <input type="text" class="form-control" name="check" id="check"
                            placeholder="Введите поверку">
                    </div>
                    {{-- всего расчитывается автоматически в ProjectController --}}
                    {{-- <div class="form-group mb-3">
                        <input type="text" class="form-control" name="total" id="total" placeholder="Всего"
                            value="250">
                    </div> --}}
                </div>
                {{-- Итого --}}
                <div class="total-add alert pt-5">
                    <h2>IV ИТОГО</h2>
                    <div class="form-group mb-3">
                        <label for="kdDays">Разработка РКД (дн.):</label>
                        <input type="text" class="form-control" name="kdDays" id="kdDays"
                            placeholder="Введите кол-во дней">
                    </div>
                    <div class="form-group mb-3">
                        <label for="equipmentDays">Комплектация (дн.):</label>
                        <input type="text" class="form-control" name="equipmentDays" id="equipmentDays"
                            placeholder="Введите кол-во дней">
                    </div>
                    <div class="form-group mb-3">
                        <label for="productionDays">Производство (дн.):</label>
                        <input type="text" class="form-control" name="productionDays" id="productionDays"
                            placeholder="Введите кол-во дней">
                    </div>
                    <div class="form-group mb-3">
                        <label for="shipmentDays">Отгрузка (дн.):</label>
                        <input type="text" class="form-control" name="shipmentDays" id="shipmentDays"
                            placeholder="Введите кол-во дней">
                    </div>
                    {{-- Себестоимость и итого расчитывается автоматически в ProjectController --}}
                    {{-- <div class="form-group mb-3">
                        <input type="text" class="form-control" name="periodDays" id="periodDays"
                            placeholder="Итого срок  реализации (дн.)" value="250">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="price" id="price"
                            placeholder="Себестоимость  (руб. без НДС)" value="250">
                    </div> --}}
                </div>
                {{-- Уровень наценки --}}
                <div class="markups-add alert pt-5">
                    <h2>V Уровень наценки</h2>
                    <div id="markups-inputs">
                        <div class="mb-3">
                            <div class="form-group mb-3">
                                <label for="date">Дата:</label>
                                <input type="date" class="form-control" name="markups[0][date]" id="date"
                                    placeholder="Выберите дату">
                            </div>
                            <div class="form-group mb-3">
                                <label for="percentage">% наценки:</label>
                                <input type="text" class="form-control" name="markups[0][percentage]" id="percentage"
                                    placeholder="Введитепроцент наценки">
                            </div>
                            <div class="form-group mb-3">
                                <label for="priceSubTkp">Сумма подачи ТКП в руб. без НДС:</label>
                                <input type="text" class="form-control" name="markups[0][priceSubTkp]"
                                    id="priceSubTkp" placeholder="Введите сумму">
                            </div>
                            <div class="form-group mb-3">
                                <label for="agreedFio">С кем согласовано (Фамилия И.О.):</label>
                                <input type="text" class="form-control" name="markups[0][agreedFio]" id="agreedFio"
                                    placeholder="Введите ФИО">
                            </div>
                        </div>
                    </div>
                    {{-- <button id="addMore-markups" data-target="markups" class="btn btn-secondary addMore-button">Добавить еще
                        уровень наценки</button> --}}
                </div>
                {{-- Риски --}}

                <div class="risks-add alert pt-3">
                    <h4 class="text-center">Риски</h4>
                    {{-- <div id="risks-inputs">
                        <div class="form-group mb-3">
                            <label for="riskName">Наименование риска:</label>
                            <input type="riskName" class="form-control" name="risks[0][riskName]" id="riskName"
                                placeholder="Введите наименование риска">
                        </div>
                    </div>
                    <button id="addMore-risks" data-target="risks" class="btn btn-secondary addMore-button">Добавить еще
                        риск</button> --}}
                    <div id="dependentFields" class="input-field">

                        <div class="form-group mb-3">
                            <label for="risk_name">Наименование риска</label>
                            <select class="form-select" name="risk_name" id="risk_name" required>
                                <option value="" disabled selected>Выберите наименование</option>
                                @foreach ($baseRisks as $baseRisk)
                                    <option value="{{ $baseRisk->nameRisk }}">
                                        {{ $baseRisk->nameRisk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="risk_reason">Причина риска</label>
                            <ul class="json_field" id="reasonList"></ul>
                        </div>
                        <div class="form-group mb-3">
                            <label for="risk_consequences">Последствия наступления риска</label>
                            <ul class="json_field" id="consequenceList"></ul>
                        </div>
                        <div class="form-group mb-3">
                            <label for="risk_counteraction">Противодействие риску</label>
                            <ul class="json_field" id="counteringRiskList"></ul>
                        </div>
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="risk_term">Срок</label>
                            <input id="termList" type="text" class="input_editable" name="risk_term" value=""
                                readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="risk_measures">Мероприятия при осуществлении риска</label>
                            <ul class="json_field" id="riskManagMeasuresList"></ul>
                        </div>
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="risk_probability">Вероятность: </label>
                            <select name="risk_probability" id="risk_probability-select" required>
                                <option value="">Выберите вероятность</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="8">8</option>
                                <option value="16">16</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="risk_influence">Влияние: </label>
                            <select name="risk_influence" id="risk_influence-select" required>
                                <option value="">Выберите влияние</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="8">8</option>
                                <option value="16">16</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="risk_mark">Отметка о реализации мероприятий в отношении рисков: </label>
                            <select name="risk_mark" id="risk_mark-select" required>
                                <option value="">Выберите отметку</option>
                                <option value="Выполнено">Выполнено</option>
                                <option value="Не выполнено">Не выполнено</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="risk_resp">Отвественный за выполнение мероприятий</label>
                            <input class="input_editable" id="risk_resp" type="text" name="risk_resp"
                                placeholder="Введите ФИО и должность" required>
                        </div>
                        <div class="form-group mb-3 d-flex flex-column">
                            <label for="risk_endTerm">Срок</label>
                            <input class="input_editable" id="risk_endTerm" type="text" name="risk_endTerm"
                                placeholder="Введите срок" required>
                        </div>
                        
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary mt-4">Создать</button>
            <a href="/project-maps/all" type="button" class="btn btn-secondary mt-4" id="cancelButton">Отмена</a>
        </form>
    </div>

    <script>
        // добавление доп строк
        $(document).ready(function() {
            // индесы для каждого из разделов
            let indices = {
                equipment: 1,
                markups: 1,
                contacts: 1,
                risks: 1
            };
            /* при нажатии на кнопки определяем какой у нас target и взависимости от него добавляет HTML, 
               возвращенный функцией getHtml, в соответствующую секцию */
            $(".addMore-button").click(function(event) {
                event.preventDefault();
                const target = $(this).data("target");

                $(`#${target}-inputs`).append(getHtml(target, indices[target]));
                indices[target]++;
            });
        });
        // функция возвращающая html в секцию
        function getHtml(target, index) {
            let removeButton =
                `<button class="btn btn-danger remove-btn" data-index="${index}" data-target="${target}">Удалить</button>`;
            switch (target) {
                case 'equipment':
                    return `
                    <tr data-target="${target}" data-index="${index}">        
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
                    </tr>`
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
                    </div>`
                case 'contacts':
                    return `<div class="mb-3 block" data-target="${target}" data-index="${index}">---
                        <div class="form-group mb-3">
                            <label for="fio">ФИО:</label>
                            <input type="fio" class="form-control" name="contacts[${index}][fio]" id="fio"
                                placeholder="Введите ФИО">
                        </div>
                        <div class="form-group mb-3">
                            <label for="post">Должность/ Организация:</label>
                            <input type="text" class="form-control" name="contacts[${index}][post]" id="post"
                                placeholder="Введите должность/организацию">
                        </div>
                        <div class="form-group mb-3">
                            <label for="responsibility">Зона ответственности:</label>
                            <input type="text" class="form-control" name="contacts[${index}][responsibility]" id="responsibility"
                                placeholder="Введите зону ответственности">
                        </div>
                        <div class="form-group mb-3">
                            <label for="contact">Телефон / эл. почта:</label>
                            <input type="text" class="form-control" name="contacts[${index}][contact]" id="contact"
                                placeholder="Введите телефон/эл.почту">
                        </div>
                        ${removeButton}
                    </div>`
                case 'risks':
                    return `<div class="form-group mb-3 block" data-target="${target}" data-index="${index}">---
                        <label for="riskName">Наименование риска:</label>
                        <input type="riskName" class="form-control" name="risks[${index}][riskName]" id="riskName"
                            placeholder="Введите наименование риска">
                            ${removeButton}
                    </div>`
            }
        }
        $(document).on('click', '.remove-btn', function(e) {
            e.preventDefault();
            let target = $(this).data('target');
            let index = $(this).data('index');
            $(`[data-target=${target}][data-index=${index}]`).remove();
        });

        //соединение номера проекта (1-23) с названием (ЭОБ)
        $(document).ready(function() {
            $('#projNumSuf').change(function() {
                var projNumPre = $('#projNumPre').val();
                var projNumSuf = $(this).val();
                var combinedValue = projNumPre + " " + projNumSuf;
                $('#projNumCombined').val(combinedValue);
            });


            // автосохранение данных
            // function autoSaveProjectData() {
            //     var formData = new FormData(document.getElementById('addMap'));

            //     $.ajax({
            //         url: '{{ route('autosave-project-data') }}',
            //         type: 'POST',
            //         data: formData,
            //         contentType: false,
            //         processData: false,
            //         success: function(response) {
            //             console.log(response);
            //         },
            //         error: function(error) {
            //             console.error(error);
            //         }
            //     });
            // }

            // setInterval(autoSaveProjectData, 5000); // Автосохранение каждые 2 секунды

            // $('#cancelButton').click(function() {
            //     alert('Сохранение отменено');
            // });
        });




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

        });
    </script>
@endsection
