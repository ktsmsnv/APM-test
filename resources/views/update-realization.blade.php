@extends('layouts.app')

@section('content')
    <div class="container updateProject">
        <h1 class="mb-5">Редактирование реализации для карты проекта {{ $project->projNum }}</h1>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-realization-tab" data-bs-toggle="pill" data-bs-target="#pills-realization"
                    type="button" role="tab" aria-controls="pills-realization"
                    aria-selected="false">Реализация</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <form action="{{ route('realization-update-submit', $project->id) }}" method="post">
                @csrf
                {{-- реализация редактирование --}}
                <div class="tab-pane fade show active" id="pills-realization" role="tabpanel" aria-labelledby="pills-realization-tab">
                    <div class="d-flex flex-column gap-5">
                        <div>
                            <h4 class="text-center mb-3">Базовая справка</h4>
                            <table id="basic-table" class="input-field ">
                                <thead class="d-none">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->basicReference ?? [] as $item)
                                        <tr>
                                            <th>Наименование проекта</th>
                                            <td colspan="3">
                                                <div class="col-3">
                                                    <input type="text" name="projName" value="{{ $item->projName }}"
                                                        class="input_editable">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Заказчик проекта</th>
                                            <td colspan="3">
                                                <div class="col-3">
                                                    <input type="text" name="projCustomer"
                                                        value="{{ $item->projCustomer }}" class="input_editable" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Начало проекта</th>
                                            <td>
                                                <div class="col-3">
                                                    <input type="date" name="startDate" value="{{ $item->startDate }}"
                                                        class="input_editable" id="startDate">
                                                </div>
                                            </td>
                                            <th>Окончание проекта</th>
                                            <td>
                                                <div class="col-3">
                                                    <input type="date" name="endDate" value="{{ $item->endDate }}"
                                                        class="input_editable" id="endDate">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Цель проекта</th>
                                            <td colspan="3">
                                                <div class="col-3">
                                                    <input type="text" name="projGoal" value="{{ $item->projGoal }}"
                                                        class="input_editable">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Куратор проекта/Руководитель направления</th>
                                            <td colspan="3">
                                                <div class="col-3">
                                                    <input type="text" name="projCurator2"
                                                        value="{{ $item->projCurator }}" class="input_editable">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Руководитель/инициатор проекта</th>
                                            <td colspan="3">
                                                <div class="col-3">
                                                    <input type="text" name="projManager"
                                                        value="{{ $item->projManager }}" class="input_editable" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <table id="info-table" class="input-field">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Проект</th>
                                        <th rowspan="2">Контрагент</th>
                                        <th rowspan="2">№ Договора/Спецификации</th>
                                        <th colspan="2">Себестоимость</th>
                                        <th rowspan="2">Стоимость контракта</th>
                                        <th rowspan="2">Дата начала</th>
                                        <th colspan="2">Дата окончания</th>
                                        <th rowspan="2">Рекламация</th>
                                    </tr>
                                    <tr>
                                        <th>План</th>
                                        <th>Факт</th>
                                        <th>План</th>
                                        <th>Факт</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->basicInfo ?? [] as $item)
                                        <tr>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="project_num" id="project"
                                                        value="{{ $item->project_num }}" class="input_editable" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="contractor" value="{{ $item->contractor }}"
                                                        class="input_editable" id="contractor" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="contract_num" id="contract_num"
                                                        value="{{ $item->contract_num }}" class="input_editable">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="price_plan"
                                                        value="{{ $item->price_plan }}" id="price_plan"
                                                        class="input_editable" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="price_fact"
                                                        value="{{ $item->price_fact }}" id="price_fact"
                                                        class="input_editable">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="contract_price" id="contract_price"
                                                        value="{{ $item->contract_price }}" class="input_editable">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="start_date"
                                                        value="{{ $item->start_date }}" id="start_dateInfo"
                                                        class="input_editable" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="end_date_plan" id="end_date_plan"
                                                        value="{{ $item->end_date_plan }}" class="input_editable"
                                                        readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="end_date_fact" id="end_date_fact"
                                                        value="{{ $item->end_date_fact }}" class="input_editable">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="complaint"
                                                        value="{{ $item->complaint }}" id="complaint"
                                                        class="input_editable">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <h4 class="text-center mb-3">Состав рабочей группы и ответственность</h4>
                            <table id="workGroup-table" class="input-field">
                                <thead>
                                    <tr>
                                        <th>Роль участника рабочей группы</th>
                                        <th>Ответственный</th>
                                        <th>Зона ответствеености</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->workGroup ?? [] as $item)
                                        <tr>
                                            <td>Куратор проекта</td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="projCurator"
                                                        value="{{ $item->projCurator }}" class="input_editable">
                                                </div>
                                            </td>
                                            <td> Стратегическое управление проектом. <br>
                                                Выделение ресурсов и разрешения конфликтных ситуаций. <br>
                                                Определение уровня прибыли стадий проекта. </td>
                                        </tr>
                                        <tr>
                                            <td>Руководитель проекта</td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="projDirector"
                                                        value="{{ $item->projDirector }}" class="input_editable">
                                                </div>
                                            </td>
                                            <td> Формирование расчетной базы проекта/стадии проекта. <br>
                                                Ведение деловой переписки с Заказчиком. <br>
                                                Инициация задач и контроль исполнения. <br>
                                                Оперативное управление проектом. <br>
                                                Регулярный контроль бюджета, сроков реализации стадии проекта.<br>
                                                Контроль рисков и инициация выработки корректирующих мероприятий. <br>
                                                Формирование отгрузочных документов для закрытия проекта/стадии проекта.
                                                <br>
                                                Итоговая отчетность.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Техлид</td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="techlid" value="{{ $item->techlid }}"
                                                        class="input_editable">
                                                </div>
                                            </td>
                                            <td> Выработка технических решений в рамках реализации проекта. <br>
                                                Техническое сопровождение проекта. <br>
                                                Выполнение экспертной оценки. <br>
                                                Разработка РКД с инициацией соответствующих документов/сущностей в ERP.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Производство</td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="production"
                                                        value="{{ $item->production }}" class="input_editable">
                                                </div>
                                            </td>
                                            <td> Курирование этапа производства. <br>
                                                Контроль бюджета производимого оборудования. <br>
                                                Контроль сроков производства. <br>
                                                Контроль ресурса производственного блока. <br>
                                                Доклад о статусе производства. <br>
                                                Создание соответсвующих документов/сущностей в ERP. <br>
                                                Инициация закупа. </td>
                                        </tr>
                                        <tr>
                                            <td>Снабжение</td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="supply" value="{{ $item->supply }}"
                                                        class="input_editable">
                                                </div>
                                            </td>
                                            <td> Обеспечение проекта необходимыми ТМЦ. <br>
                                                Доклад о статусе закупа. <br>
                                                Создание соответсвующих документов/сущностей в ERP. </td>
                                        </tr>
                                        <tr>
                                            <td>Логист</td>
                                            <td>
                                                <div class="col-3">
                                                    <input type="text" name="logistics"
                                                        value="{{ $item->logistics }}" class="input_editable">
                                                </div>
                                            </td>
                                            <td> Обеспечение доставки оборудования заказчику в установленные сроки. </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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


                $('#startDate').on('input', function() {
                    // При изменении значения поля, копировать его в другое поле
                    let startDate = $(this).val();
                    $('#start_dateInfo').val(startDate);
                });
                $('#endDate').on('input', function() {
                    let endDate = $(this).val();
                    $('#end_date_plan').val(endDate);
                });

            });
        </script>
    @endsection
