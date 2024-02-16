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
                                                <input type="text" name="contractor" value="{{ $project->contractor }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <div class="input-field d-flex gap-3 mb-2">
                                            <p>Дата поступления заявки:</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="date" name="date_application"
                                                    value="{{ $project->date_application }}" class="input_editable">
                                            </div>
                                        </div>
                                        <div class="input-field d-flex gap-3 mb-2">
                                            <p>Дата подачи предложения:</p>
                                            <div class="col-3" style="width: 20%;">
                                                <input type="date" name="date_offer" value="{{ $project->date_offer }}"
                                                    class="input_editable">
                                            </div>
                                        </div>
                                        <h4 class="mt-4 mb-3">Виды работ</h4>
                                        <div class="d-flex gap-5">
                                            <div class="d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="delivery"
                                                        id="delivery" {{ $project->delivery ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="delivery">Поставка</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="pir"
                                                        id="pir" {{ $project->pir ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pir">ПИР</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kd"
                                                        id="kd" {{ $project->kd ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kd">КД</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="production"
                                                        id="production" {{ $project->production ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="production">Производство</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="smr"
                                                        id="smr" {{ $project->smr ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="smr">ШМР</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="pnr"
                                                        id="pnr" {{ $project->pnr ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pnr">ПНР</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="po"
                                                        id="po" {{ $project->po ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="po">ПО</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="cmr"
                                                        id="cmr" {{ $project->cmr ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cmr">СМР</label>
                                                </div>
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
                                    II Себестоимость оборудования
                                </button>
                            </h2>
                            <div id="equipment-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="equipment-headingTwo">
                                <div class="accordion-body">
                                    <table id="equipment-datatable" class="display nowrap projMap" style="width:100%">
                                        <thead>
                                            <tr>
                                                {{-- <th style="max-width: 50px;">ID</th> --}}
                                                <th>Наименование ТМЦ</th>
                                                <th>Производитель</th>
                                                <th>Ед. изм.</th>
                                                <th>Кол-во</th>
                                                <th>Цена за ед. (руб. без НДС)</th>
                                                {{-- <th>Стоимость (руб. без НДС)</th> --}}
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="equipment-inputs">
                                            @foreach ($project->equipment as $index => $item)
                                                <tr class="input-field" data-id="{{ $item->id }}"
                                                    data-index="{{ $index }}" data-target="equipment">

                                                    <input type="hidden" name="equipment[{{ $index }}][id]"
                                                        value="{{ $item->id }}" class="input_editable">

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
                                                    <td>
                                                        <a class="remove-btn btn btn-xs btn-danger"
                                                            data-target="equipment" data-index="{{ $index }}"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" class="addMore-button btn btn-success mt-4"
                                        data-target="equipment">Добавить
                                        строку</button>
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
                                                <th>Наименование</th>
                                                <th>Стоимость (руб. без НДС)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="additional_expenses-inputs">
                                            @if ($project->expenses->count() > 0)
                                                @foreach ($project->expenses as $index => $expense)
                                                    <tr>
                                                        <td>Командировочные</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="expense[{{ $index }}][commandir]"
                                                                    value="{{ $expense->commandir }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>РД</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="rd"
                                                                    name="expense[{{ $index }}][rd]"
                                                                    value="{{ $expense->rd }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>ШМР</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="shmr"
                                                                    name="expense[{{ $index }}][shmr]"
                                                                    value="{{ $expense->shmr }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>ПНР</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="pnr"
                                                                    name="expense[{{ $index }}][pnr]"
                                                                    value="{{ $expense->pnr }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Сертификаты</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="cert"
                                                                    name="expense[{{ $index }}][cert]"
                                                                    value="{{ $expense->cert }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Доставка/Логистика</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="delivery"
                                                                    name="expense[{{ $index }}][delivery]"
                                                                    value="{{ $expense->delivery }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Растаможка</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="rastam"
                                                                    name="expense[{{ $index }}][rastam]"
                                                                    value="{{ $expense->rastam }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Разработка ППО</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="ppo"
                                                                    name="expense[{{ $index }}][ppo]"
                                                                    value="{{ $expense->ppo }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Банковская гарантия</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="guarantee"
                                                                    name="expense[{{ $index }}][guarantee]"
                                                                    value="{{ $expense->guarantee }}"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Поверка</td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text" id="check"
                                                                    name="expense[{{ $index }}][check]"
                                                                    value="{{ $expense->check }}" class="input_editable">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Для каждого дополнительного расхода -->
                                                    @foreach ($expense->additionalExpenses as $additionalExpense)
                                                        <tr>
                                                            <td>Доп. расход</td>
                                                            <td>
                                                                <input type="text"
                                                                    name="additional_expenses[{{ $additionalExpense->id }}][cost]"
                                                                    value="{{ $additionalExpense->cost }}">
                                                                <button
                                                                    class="delete_additionalExpense btn btn-xs btn-danger"
                                                                    data-target="additional_expenses"
                                                                    data-id="{{ $additionalExpense->id }}">Удалить</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            <button type="button" class="addMore-button btn btn-success mt-4"
                                                data-target="additional_expenses">Добавить расходы</button>
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
                                    IV КСГ
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
                                            <p>Доставка (дн.):</p>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="markups-inputs">
                                            @if ($project->markups->count() > 0)
                                                @foreach ($project->markups as $index => $markup)
                                                    <tr data-id="{{ $markup->id }}" data-index="{{ $index }}"
                                                        data-target="markups">
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[{{ $index }}][id]"
                                                                    value="{{ $markup->id }}" class="input_editable"
                                                                    readonly>
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
                                                        <td>
                                                            <a class="remove-btn btn btn-xs btn-danger"
                                                                data-index="{{ $index }}"
                                                                data-id="{{ $markup->id }}" data-target="markups">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            @endif
                                        </tbody>
                                    </table>
                                    <button type="button" class="addMore-button btn btn-success mt-4"
                                        data-target="markups">Добавить
                                        строку</button>
                                    <div class="mt-5">
                                        <h4 class="text-center mb-3">Контакт-лист</h4>
                                        <table id="markups-contacts-datatable" class="display nowrap projMap"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    {{-- <th>№</th> --}}
                                                    <th>ФИО</th>
                                                    <th>Должность</th>
                                                    <th>Организация</th>
                                                    <th>Зона ответственности</th>
                                                    <th>Телефон</th>
                                                    <th>эл.почта</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="contacts-inputs">
                                                @if ($project->contacts->count() > 0)
                                                    @foreach ($project->contacts as $index => $contact)
                                                        <tr data-id="{{ $contact->id }}"
                                                            data-index="{{ $index }}"
                                                            data-target="markups-contacts">

                                                            <input type="hidden" name="contact[{{ $index }}][id]"
                                                                value="{{ $contact->id }}" class="input_editable"
                                                                readonly>

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
                                                                        name="contact[{{ $index }}][organization]"
                                                                        value="{{ $contact->organization }}"
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
                                                                        name="contact[{{ $index }}][phone]"
                                                                        value="{{ $contact->phone }}"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[{{ $index }}][email]"
                                                                        value="{{ $contact->email }}"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a class="remove-btn btn btn-xs btn-danger"
                                                                    data-index="{{ $index }}"
                                                                    data-id="{{ $contact->id }}"
                                                                    data-target="markups-contacts">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="addMore-button btn btn-success mt-4"
                                            data-target="contacts">Добавить
                                            строку</button>
                                    </div>
                                    <div class="mt-5">
                                        <h4 class="text-center mb-3">Риски</h4>
                                        <table id="risks-datatable" class="display nowrap projMap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th>Наименование риска</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="risks-inputs">
                                                @if ($project->calc_risks->count() > 0)
                                                    @foreach ($project->calc_risks as $index => $risk)
                                                        <tr data-id="{{ $risk->id }}"
                                                            data-index="{{ $index }}" data-target="risks">
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
                                                            <td>
                                                                <a class="remove-btn btn btn-xs btn-danger"
                                                                    data-index="{{ $index }}"
                                                                    data-id="{{ $risk->id }}" data-target="risks">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                @endif
                                            </tbody>
                                        </table>
                                        <button type="button" class="addMore-button btn btn-success mt-4"
                                            data-target="risks">Добавить
                                            строку</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="equipment_ids[]" value="">
                    <input type="hidden" name="markup_ids[]" value="">
                    <input type="hidden" name="expense_ids[]" value="">
                    <input type="hidden" name="contact_ids[]" value="">
                    <input type="hidden" name="risk_ids[]" value="">

                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <input type="submit" class="btn btn-primary mt-4" value="Сохранить изменения"
                        id="save-changes-btn">
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


                const indices = {
                    equipment: {{ count($project->equipment) }},
                    markups: {{ count($project->markups) }},
                    contacts: {{ count($project->contacts) }},
                    risks: {{ count($project->risks) }},
                };

                $(".addMore-button").click(function(event) {
                    event.preventDefault();
                    const target = $(this).data("target");
                    $(`#${target}-inputs`).append(getHtml(target, indices[target]));
                    indices[target]++;
                });
                // функция возвращающая html в секцию
                function getHtml(target, index) {
                    let removeButton =
                        `<button class="remove-btn btn btn-xs btn-danger" href="#" data-index="${index}" data-target="${target}"><i class="fa-solid fa-trash-can"></i></button>`;
                    switch (target) {
                        case 'equipment':
                            return `
                                <tr data-target="${target}" data-index="${index}">    
                                            <td>
                                                <input type="text" class="form-control" name="equipment[${index}][nameTMC]" id="nameTMC"
                                                placeholder="Введите наименование ТМЦ">
                                            </td>
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
                            return `
                                <tr data-target="${target}" data-index="${index}">        
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="date"
                                                                    name="markup[${index}][date]" class="input_editable">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[${index}][percentage]"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[${index}][priceSubTkp]"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-3">
                                                                <input type="text"
                                                                    name="markup[${index}][agreedFio]"
                                                                    class="input_editable">
                                                            </div>
                                                        </td>
                                                        <td style="border:none;">${removeButton} </td>
                                </tr>`

                        case 'contacts':
                            return `
                                <tr data-target="${target}" data-index="${index}">
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[${index}][fio]"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[${index}][post]"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[${index}][responsibility]"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-3">
                                                                    <input type="text"
                                                                        name="contact[${index}][contact]"
                                                                        class="input_editable">
                                                                </div>
                                                            </td>
                                <td style="border:none;">${removeButton} </td>
                                </tr>`
                        case 'risks':
                            return `
                                <tr data-target="${target}" data-index="${index}">
                                    <td>
                                        <div class="col-3"> 
                                            <input type="text" name="risk[${index}][riskName]" class="input_editable">
                                        </div>
                                    </td>
                                    <td style="border:none;">${removeButton} </td>
                                </tr>`
                        case 'additional_expenses':
                            return `
                                <tr data-target="${target}" data-index="${index}">
                                    <td>
                                        Доп. расход
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="additional_expenses[${index}][cost]" placeholder="Введите стоимость">
                                      ${removeButton}
                                    </td>
                                    
                                </tr>`;
                    }
                }


                $(document).on('click', '.delete_additionalExpense', function(e) {
                    e.preventDefault();
                    $(this).closest('tr').remove(); // Удаляем ближайший родительский элемент <tr>
                    let id = $(this).data('id');
                    let target = $(this).data('target');
                    let projectId = $('input[name="project_id"]').val();
                    hideRow2(target, null, id, projectId);
                });

                $(document).on('click', '.remove-btn', function(e) {
                    e.preventDefault();
                    let target = $(this).data('target');
                    let index = $(this).data('index');
                    let id = $(this).data('id');

                    hideRow(target, index, id);
                    $(`[data-target=${target}][data-index=${index}]`).remove();

                    // Удаление соответствующего скрытого поля
                    $(`input[name="${target}_ids\\[\\]"][value="${id}"]`).remove();
                });

                function hideRow(target, index, id) {
                    $(`[data-target=${target}][data-index=${index}][data-id=${id}]`).addClass('to-delete');
                    $.ajax({
                        url: `/delete-row/${target}/${id}`,
                        type: 'POST', // Можно использовать DELETE, если сервер поддерживает DELETE-запросы
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response); // Для отладки
                            if (response.success) {
                                $(`[data-target=${target}][data-index=${index}][data-id=${id}]`)
                                    .remove(); // Удаляем строку из таблицы
                            } else {
                                console.error(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Вывод ошибки в консоль
                        }
                    });
                }

                function hideRow2(target, index, id, projectId) {
                    $(`[data-target=${target}][data-index=${index}][data-id=${id}]`).addClass('to-delete');
                    $.ajax({
                        url: `/delete-row/${target}/${id}`,
                        type: 'POST', // Можно использовать DELETE, если сервер поддерживает DELETE-запросы
                        data: {
                            _token: '{{ csrf_token() }}',
                            project_id: projectId // Передаем id проекта
                        },
                        success: function(response) {
                            console.log(response); // Для отладки
                            if (response.success) {
                                $(`[data-target=${target}][data-index=${index}][data-id=${id}]`).remove();
                            } else {
                                console.error(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Вывод ошибки в консоль
                        }
                    });
                }

                $('#save-changes-btn').click(function() {
                    $('.to-delete').each(function() {
                        let target = $(this).data('target');
                        let id = $(this).data('id');
                        deleteRow(target, id); // добавляем вызов функции deleteRow
                    });
                    $('#delete-marked-rows-form').submit();
                });

            });
        </script>
    @endsection
