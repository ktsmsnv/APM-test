@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Добавить карту проекта</h1>
        <form action="{{ route('project-store') }}" method="post" id="addMap">
            @csrf
            {{-- Общая информация --}}
            <div class="project-add pt-5">
                <h2>I Общая информация по проекту</h2>
                <div class="form-group mb-3">
                    <label for="projNum">Номер проекта по реестру:</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="projNumPre" id="projNumPre"
                            value="{{ $projectNum }}-{{ $currentYear }}" readonly>
                        <div class="form-group mb-3">
                            <input list="projNumbs" name="projNumSuf" required placeholder="Выберите тип" id="projNumSuf" />
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
                    <input type="text" class="form-control" name="projManager" id="projManager"
                        placeholder="Введите имя руководителя проекта">
                </div>
                <div class="form-group mb-3">
                    <label for="objectName">Наименование объекта:</label>
                    <input type="text" class="form-control" name="objectName" id="objectName"
                        placeholder="Введите название объекта">
                </div>
                <div class="form-group mb-3">
                    <label for="endCustomer">Конечный заказчик:</label>
                    <input type="text" class="form-control" name="endCustomer" id="endCustomer"
                        placeholder="Введите имя конечного заказчика">
                </div>
                <div class="form-group mb-3">
                    <label for="contractor">Контрагент:</label>
                    <input type="text" class="form-control" name="contractor" id="contractor"
                        placeholder="Введите имя контрагента">
                </div>
            </div>
            {{-- Оборудование --}}
            <div class="equipment-add pt-5">
                <h2>II Оборудование</h2>
                <div id="equipment-inputs">
                    <div class="mb-3">
                        <div class="form-group mb-3">
                            <label for="nameTMC">Наименование ТМЦ:</label>
                            <input type="text" class="form-control" name="equipment[0][nameTMC]" id="nameTMC"
                                placeholder="Введите наименование ТМЦ">
                        </div>
                        <div class="form-group mb-3">
                            <label for="manufacture">Производитель:</label>
                            <input type="text" class="form-control" name="equipment[0][manufacture]" id="manufacture"
                                placeholder="Введите производителя">
                        </div>
                        <div class="form-group mb-3">
                            <label for="unit">Ед. изм.:</label>
                            <input type="text" class="form-control" name="equipment[0][unit]" id="unit"
                                placeholder="Введите ед.изм.">
                        </div>
                        <div class="form-group mb-3">
                            <label for="count">Кол-во:</label>
                            <input type="text" class="form-control" name="equipment[0][count]" id="count"
                                placeholder="Введите количество">
                        </div>
                        <div class="form-group mb-3">
                            <label for="priceUnit">Цена за ед. (руб. без НДС):</label>
                            <input type="text" class="form-control" name="equipment[0][priceUnit]" id="priceUnit"
                                placeholder="Введите цену за ед.">
                        </div>
                        {{-- Стоимость расчитывается автоматически в ProjectController --}}
                        {{-- <div class="form-group mb-3">
                            <input type="text" class="form-control" name="equipment[0][price]" id="price"
                                placeholder="Стоимость (руб. без НДС)" value="250">
                        </div> --}}
                    </div>
                </div>
                <button id="addMore-equipment" data-target="equipment" class="btn btn-secondary addMore-button">Добавить еще
                    оборудование</button>
            </div>
            {{-- Прочие расходы --}}
            <div class="expenses-add pt-5">
                <h2>III Прочие расходы (руб. без НДС)</h2>
                <div class="form-group mb-3">
                    <label for="commandir">Командировочные:</label>
                    <input type="text" class="form-control" name="commandir" id="commandir"
                        placeholder="Введите командировочные">
                </div>
                <div class="form-group mb-3">
                    <label for="rd">РД:</label>
                    <input type="text" class="form-control" name="rd" id="rd" placeholder="Введите РД">
                </div>
                <div class="form-group mb-3">
                    <label for="shmr">ШМР:</label>
                    <input type="text" class="form-control" name="shmr" id="shmr" placeholder="Введите ШМР">
                </div>
                <div class="form-group mb-3">
                    <label for="pnr">ПНР:</label>
                    <input type="text" class="form-control" name="pnr" id="pnr" placeholder="Введите ПНР">
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
            <div class="total-add pt-5">
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
            <div class="markups-add pt-5">
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
                            <input type="text" class="form-control" name="markups[0][priceSubTkp]" id="priceSubTkp"
                                placeholder="Введите сумму">
                        </div>
                        <div class="form-group mb-3">
                            <label for="agreedFio">С кем согласовано (Фамилия И.О.):</label>
                            <input type="text" class="form-control" name="markups[0][agreedFio]" id="agreedFio"
                                placeholder="Введите ФИО">
                        </div>
                    </div>
                </div>
                <button id="addMore-markups" data-target="markups" class="btn btn-secondary addMore-button">Добавить еще
                    уровень наценки</button>
            </div>
            {{-- Контакт лист --}}
            <div class="contacts-add pt-3">
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
                <button id="addMore-contacts" data-target="contacts" class="btn btn-secondary addMore-button">Добавить
                    еще контакт</button>
            </div>
            {{-- Риски --}}
            <div class="risks-add pt-3">
                <h4 class="text-center">Риски</h4>
                <div id="risks-inputs">
                    <div class="form-group mb-3">
                        <label for="riskName">Наименование риска:</label>
                        <input type="riskName" class="form-control" name="risks[0][riskName]" id="riskName"
                            placeholder="Введите наименование риска">
                    </div>
                </div>
                <button id="addMore-risks" data-target="risks" class="btn btn-secondary addMore-button">Добавить еще
                    риск</button>
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
                    return `<div class="mb-3 block" data-target="${target}" data-index="${index}">---
                        <div class="form-group mb-3">
                            <label for="nameTMC">Наименование ТМЦ:</label>
                            <input type="text" class="form-control" name="equipment[${index}][nameTMC]" id="nameTMC"
                                placeholder="Введите наименование ТМЦ">
                        </div>
                        <div class="form-group mb-3">
                            <label for="manufacture">Производитель:</label>
                            <input type="text" class="form-control" name="equipment[${index}][manufacture]" id="manufacture"
                                placeholder="Введите производителя">
                        </div>
                        <div class="form-group mb-3">
                            <label for="unit">Ед. изм.:</label>
                            <input type="text" class="form-control" name="equipment[${index}][unit]" id="unit"
                                placeholder="Введите ед.изм.">
                        </div>
                        <div class="form-group mb-3">
                            <label for="count">Кол-во:</label>
                            <input type="text" class="form-control" name="equipment[${index}][count]" id="count"
                                placeholder="Введите количество">
                        </div>
                        <div class="form-group mb-3">
                            <label for="priceUnit">Цена за ед. (руб. без НДС):</label>
                            <input type="text" class="form-control" name="equipment[${index}][priceUnit]" id="priceUnit"
                                placeholder="Введите цену за ед.">
                        </div>
                        ${removeButton}
                        </div>`
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
    </script>
@endsection
