@extends('layouts.app')

@section('content')
    <div class="container updateProject">
        <h1 class="mb-5">Редактирование расчета для карты проекта {{ $project->projNum }}</h1>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-calculation-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-calculation" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">Расчет</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <form action="{{ route('project-map-update-submit', $project->id) }}" method="post">
                @csrf
                {{-- расчет реадктирование --}}
                <div class="tab-pane fade show active" id="pills-calculation" role="tabpanel"
                    aria-labelledby="pills-calculation-tab">
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
                                    @csrf
                                    <div class="d-flex flex-column">
                                        <div class="input-field d-flex gap-3 mb-2">
                                            <p>Номер проекта по реестру:</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="projNum" value="{{ $project->projNum }}"
                                                    class="input_editable" readonly>
                                            </div>
                                        </div>
                                        <div class="input-field d-flex gap-3 mb-2">
                                            <p>Руководитель проекта:</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="projManager" value="{{ $project->projManager }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <div class="input-field d-flex gap-3 mb-2">
                                            <p>Наименование объекта:</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="objectName" value="{{ $project->objectName }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <div class="input-field d-flex gap-3 mb-2">
                                            <p>Конечный заказчик:</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="endCustomer" value="{{ $project->endCustomer }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <div class="input-field d-flex gap-3 mb-2">
                                            <p>Контрагент:</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="contractor"
                                                    value="{{ $project->contractor }}" class="input_editable">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="equipment-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#equipment-collapseTwo" aria-expanded="false"
                                    aria-controls="equipment-collapseTwo">
                                    II Оборудование
                                </button>
                            </h2>
                            <div id="equipment-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="equipment-headingTwo">
                                <div class="accordion-body">
                                    @csrf
                                    <table id="equipment-datatable" class="display nowrap projMap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="max-width: 50px;">ID</th>
                                                <th>Наименование ТМЦ</th>
                                                <th>Производитель</th>
                                                <th>Ед. изм.</th>
                                                <th>Кол-во</th>
                                                <th>Цена за ед. (руб. без НДС)</th>
                                                {{-- <th>Стоимость (руб. без НДС)</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($project->equipment as $index => $item)
                                                <tr class="input-field">
                                                    <td style="max-width: 50px;">
                                                        <input style="max-width: 50px;"type="text"
                                                            name="equipment[{{ $index }}][id]"
                                                            value="{{ $item->id }}" class="input_editable" readonly>
                                                    </td>
                                                    <td>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                name="equipment[{{ $index }}][nameTMC]"
                                                                id="nameTMC{{ $index }}"
                                                                value="{{ $item->nameTMC }}" class="input_editable">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                name="equipment[{{ $index }}][manufacture]"
                                                                id="manufacture{{ $index }}"
                                                                value="{{ $item->manufacture }}" class="input_editable">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                name="equipment[{{ $index }}][unit]"
                                                                id="unit{{ $index }}" value="{{ $item->unit }}"
                                                                class="input_editable">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                name="equipment[{{ $index }}][count]"
                                                                id="count{{ $index }}"
                                                                value="{{ $item->count }}" class="input_editable">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-3">
                                                            <input type="text"
                                                                name="equipment[{{ $index }}][priceUnit]"
                                                                id="priceUnit{{ $index }}"
                                                                value="{{ $item->priceUnit }}" class="input_editable">
                                                        </div>
                                                    </td>
                                                    {{-- <td class="total-equipment"> <input type="text" name="equipment[{{ $index }}][price]"
                                                        id="price{{ $index }}" value="{{ $item->price }}"></td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
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
                                    @csrf
                                    <table id="expenses-datatable" class="display nowrap projMap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Наименование</th>
                                                <th>Стоимость (руб. без НДС)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="input-field">
                                            @if ($project->expenses->count() > 0)
                                                @foreach ($project->expenses as $index => $expense)
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Командировочные</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="commandir"
                                                                    value="{{ $expense->commandir }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>РД</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="rd" id="rd"
                                                                    value="{{ $expense->rd }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>ШМР</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="shmr" id="shmr"
                                                                    value="{{ $expense->shmr }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>ПНР</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="pnr" id="pnr"
                                                                    value="{{ $expense->pnr }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Сертификаты</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="cert" id="cert"
                                                                    value="{{ $expense->cert }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Доставка/Логистика</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="delivery" id="delivery"
                                                                    value="{{ $expense->delivery }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>Растаможка</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="rastam" id="rastam"
                                                                    value="{{ $expense->rastam }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>Разработка ППО</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="ppo" id="ppo"
                                                                    value="{{ $expense->ppo }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td>Банковская гарантия</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="guarantee" id="guarantee"
                                                                    value="{{ $expense->guarantee }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td>Поверка</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" name="check" id="check"
                                                                    value="{{ $expense->check }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
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
                                <div class="accordion-body input-field">
                                    @csrf
                                    <div class="d-flex flex-column">
                                        <div class="d-flex gap-3">
                                            <p>Разработка РКД (дн.):</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="kdDays"
                                                    value="{{ $project->totals->first()->kdDays }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <div class="d-flex gap-3">
                                            <p>Комплектация (дн.):</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="equipmentDays"
                                                    value="{{ $project->totals->first()->equipmentDays }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <div class="d-flex gap-3">
                                            <p>Производство (дн.):</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="productionDays"
                                                    value="{{ $project->totals->first()->productionDays }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <div class="d-flex gap-3">
                                            <p>Отгрузка (дн.):</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="text" name="shipmentDays"
                                                    value="{{ $project->totals->first()->shipmentDays }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
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
                                <div class="accordion-body  input-field">
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
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[{{ $index }}][id]"
                                                                    value="{{ $markup->id }}" class="input_editable" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="date"
                                                                    name="markup[{{ $index }}][date]"
                                                                    value="{{ $markup->date }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[{{ $index }}][percentage]"
                                                                    value="{{ $markup->percentage }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[{{ $index }}][priceSubTkp]"
                                                                    value="{{ $markup->priceSubTkp }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[{{ $index }}][agreedFio]"
                                                                    value="{{ $markup->agreedFio }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="mt-5">
                                        <h4 class="text-center mb-3">Контакт-лист</h4>
                                        <table id="markups-contacts-datatable" class="display nowrap projMap"
                                            style="width:100%">
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
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[{{ $index }}][id]"
                                                                        value="{{ $contact->id }}"
                                                                        class="input_editable" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[{{ $index }}][fio]"
                                                                        value="{{ $contact->fio }}"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[{{ $index }}][post]"
                                                                        value="{{ $contact->post }}"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[{{ $index }}][responsibility]"
                                                                        value="{{ $contact->responsibility }}"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[{{ $index }}][contact]"
                                                                        value="{{ $contact->contact }}"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-5">
                                        <h4 class="text-center mb-3">Риски</h4>
                                        <table id="markups-contacts-datatable" class="display nowrap projMap"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th>Наименование риска</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($project->calc_risks->count() > 0)
                                                    @foreach ($project->calc_risks as $index => $risk)
                                                        <tr>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="risk[{{ $index }}][id]"
                                                                        value="{{ $risk->id }}"
                                                                        class="input_editable" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="risk[{{ $index }}][riskName]"
                                                                        value="{{ $risk->calcRisk_name }}"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
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
                </div>

                <input type="submit" class="btn btn-primary mt-4" value="Сохранить изменения">
            </form>
        </div>

        <script>
            let existingRows = {{ count($project->changes ?? []) }};
            let newIndex = existingRows;

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
