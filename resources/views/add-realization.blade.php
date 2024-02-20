@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">Добавление реализации для {{ $project->projNum }}</h1>
        <form action="{{ route('realization-store', $project->id) }}" method="post" style="background-color: white; padding: 15px; border-radius: 10px;">
            @csrf
            {{-- Базовая справка --}}
            <div class="mb-5">
                <h4 class="text-center mb-3">Базовая справка</h4>
                <table id="basic-table" class="">
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
                        <tr>
                            <th>Наименование проекта</th>
                            <td colspan="3">
                                <input type="text" class="form-control" name="projName" id="projName"
                                    placeholder="Введите наименование проекта">
                            </td>
                        </tr>
                        <tr>
                            <th>Заказчик проекта</th>
                            <td colspan="3">
                                <input type="text" class="form-control" name="projCustomer" id="projCustomer"
                                    value="{{ $project->endCustomer }}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Начало проекта</th>
                            <td>
                                <input type="date" class="form-control" name="startDate" id="startDate"
                                    placeholder="Выберите дату начала проекта">
                            </td>
                            <th>Окончание проекта</th>
                            <td>
                                <input type="date" class="form-control" name="endDate" id="endDate"
                                    placeholder="Выберите дату окончания проекта">
                            </td>
                        </tr>
                        <tr>
                            <th>Цель проекта</th>
                            <td colspan="3">
                                <input type="text" class="form-control" name="projGoal" id="projGoal"
                                    placeholder="Введитецель проекта"
                                    value="Получение ожидаемой выгоды/прибыли от реализации проекта">
                            </td>
                        </tr>
                        <tr>
                            <th>Куратор проекта/Руководитель направления</th>
                            <td colspan="3">
                                <input type="text" class="form-control" name="projCurator" id="projCurator"
                                    placeholder="Введите куратора проекта/руководителя направления">
                            </td>
                        </tr>
                        <tr>
                            <th>Руководитель/инициатор проекта</th>
                            <td colspan="3">
                                <input type="text" class="form-control" name="projManager" id="projManager"
                                    value="{{ $project->projManager }}" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Доп. информация --}}
            <div class="mb-3">
                <table id="info-table" class="">
                    <thead>
                        <tr>
                            <th rowspan="2">Проект</th>
                            <th rowspan="2">Контрагент</th>
                            <th rowspan="2">№ Договора/Спецификации</th>
                            <th colspan="2">Себестоимость</th>
                            <th rowspan="2">Стоимость контракта</th>
                            {{-- <th colspan="2">Прибыль</th> --}}
                            <th rowspan="2">Дата начала</th>
                            <th colspan="2">Дата окончания</th>
                            <th rowspan="2">Рекламация</th>
                        </tr>
                        <tr>
                            <th>План</th>
                            <th>Факт</th>
                            {{-- <th>План</th>
                            <th>Факт</th> --}}
                            <th>План</th>
                            <th>Факт</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="project" id="project"
                                    value="{{ $project->projNum }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="contractor" id="contractor"
                                    value="{{ $project->contractor }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="contract_num" id="contract_num"
                                    placeholder="Введите № Договора/ Спецификации">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="price_plan" id="price_plan"
                                    value="{{ $project->totals->first()->price }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="price_fact" id="price_fact"
                                    placeholder="Введите фактическую себестоимость">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="contract_price" id="contract_price"
                                    placeholder="Введите стоимость контракта">
                            </td>
                            {{-- прибыль план и факт расчитывается автоматически в realixationController --}}
                            {{-- <td>
                                    <input type="text" class="form-control" name="profit_plan" id="profit_plan" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="profit_fact" id="profit_fact" readonly>
                                </td> --}}
                            <td>
                                {{-- данные подтягиваются из базовой справки startDate --}}
                                <input type="date" class="form-control" name="start_date" id="start_dateInfo">
                            </td>
                            <td>
                                {{-- данные подтягиваются из базовой справки endDate --}}
                                <input type="date" class="form-control" name="end_date_plan" id="end_date_plan">
                            </td>
                            <td>
                                <input type="date" class="form-control" name="end_date_fact" id="end_date_fact"
                                    placeholder="Выберите фактическую дату окончания">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="complaint" id="complaint"
                                    placeholder="Введите рекламацию">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Состав рабочей группы и ответственность --}}
            <div class="mb-5">
                <h4 class="text-center mb-3">Состав рабочей группы и ответственность</h4>
                <table id="workGroup-table" class="">
                    <thead>
                        <tr>
                            <th>Роль участника рабочей группы</th>
                            <th>Ответственный</th>
                            <th>Зона ответствеености</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>Куратор проекта</td>
                                <td>
                                     <input type="text" class="form-control" name="projCurator2" id="projCurator2"
                                    placeholder="Введите куратора проекта">
                                </td>
                                <td> Стратегическое управление проектом. <br>
                                    Выделение ресурсов и разрешения конфликтных ситуаций. <br>
                                    Определение уровня прибыли стадий проекта. </td>
                            </tr>
                            <tr>
                                <td>Руководитель проекта</td>
                                <td>
                                     <input type="text" class="form-control" name="projDirector" id="projDirector"
                                    placeholder="Введите руководителя проекта">
                                </td>
                                <td> Формирование расчетной базы проекта/стадии проекта. <br>
                                    Ведение деловой переписки с Заказчиком. <br>
                                    Инициация задач и контроль исполнения. <br>
                                    Оперативное управление проектом. <br>
                                    Регулярный контроль бюджета, сроков реализации стадии проекта.<br>
                                    Контроль рисков и инициация выработки корректирующих мероприятий. <br>
                                    Формирование отгрузочных документов для закрытия проекта/стадии проекта. <br>
                                    Итоговая отчетность. </td>
                            </tr>
                            <tr>
                                <td>Техлид</td>
                                <td>
                                     <input type="text" class="form-control" name="techlid" id="techlid"
                                    placeholder="Введите техлида">
                                </td>
                                <td> Выработка технических решений в рамках реализации проекта. <br>
                                    Техническое сопровождение проекта. <br>
                                    Выполнение экспертной оценки. <br>
                                    Разработка РКД с инициацией соответствующих документов/сущностей в ERP. </td>
                            </tr>
                            <tr>
                                <td>Производство</td>
                                <td>
                                     <input type="text" class="form-control" name="production" id="production"
                                    placeholder="Введите ответственного за произ-во">
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
                                     <input type="text" class="form-control" name="supply" id="supply"
                                    placeholder="Введите ответственного за снабжение">
                                </td>
                                <td> Обеспечение проекта необходимыми ТМЦ. <br>
                                    Доклад о статусе закупа. <br>
                                    Создание соответсвующих документов/сущностей в ERP. </td>
                            </tr>
                            <tr>
                                <td>Логист</td>
                                <td>
                                     <input type="text" class="form-control" name="logistics" id="logistics"
                                    placeholder="Введите ответственного за логистику">
                                </td>
                                <td> Обеспечение доставки оборудования заказчику в установленные сроки. </td>
                            </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Сохранить</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
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
