@if ($project && $project->basicReference && $project->basicInfo && $project->basicReference->isNotEmpty() && $project->basicInfo->isNotEmpty())
<div class="realization d-flex flex-column gap-5">
    <div class="d-flex flex-column gap-5">
        {{-- @if ($project->basic_reference && $project->basic_reference->count() > 0) --}}
            <div>
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
                        @foreach ($project->basicReference ?? [] as $item)
                            <tr>
                                <th>Наименование проекта</th>
                                <td colspan="3">{{ $item->projName }}</td>
                            </tr>
                            <tr>
                                <th>Заказчик проекта</th>
                                <td colspan="3">{{ $item->projCustomer }}</td>
                            </tr>
                            <tr>
                                <th>Начало проекта</th>
                                <td>{{ $item->startDate }}</td>
                                <th>Окончание проекта</th>
                                <td>{{ $item->endDate }}</td>
                            </tr>
                            <tr>
                                <th>Цель проекта</th>
                                <td colspan="3">{{ $item->projGoal }}</td>
                            </tr>
                            <tr>
                                <th>Куратор проекта/Руководитель направления</th>
                                <td colspan="3">{{ $item->projCurator }}</td>
                            </tr>
                            <tr>
                                <th>Руководитель/инициатор проекта</th>
                                <td colspan="3">{{ $item->projManager }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-3">
                <table id="info-table" class="">
                    <thead>
                        <tr>
                            <th rowspan="2">Проект</th>
                            <th rowspan="2">Контрагент</th>
                            <th rowspan="2">№ Договора/Спецификации</th>
                            <th colspan="2">Себестоимость</th>
                            <th rowspan="2">Стоимость контракта</th>
                            <th colspan="2">Прибыль</th>
                            <th rowspan="2">Дата начала</th>
                            <th colspan="2">Дата окончания</th>
                            <th rowspan="2">Рекламация</th>
                        </tr>
                        <tr>
                            <th>План</th>
                            <th>Факт</th>
                            <th>План</th>
                            <th>Факт</th>
                            <th>План</th>
                            <th>Факт</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->basicInfo ?? [] as $item)
                            <tr>
                                <td>{{ $item->project_num }}</td>
                                <td>{{ $item->contractor }}</td>
                                <td>{{ $item->contract_num }}</td>
                                <td>{{ $item->price_plan }}</td>
                                <td>{{ $item->price_fact }}</td>
                                <td>{{ $item->contract_price }}</td>
                                <td>{{ $item->profit_plan }}</td>
                                <td>{{ $item->profit_fact }}</td>
                                <td>{{ $item->start_date }}</td>
                                <td>{{ $item->end_date_plan }}</td>
                                <td>{{ $item->end_date_fact }}</td>
                                <td>{{ $item->complaint }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-3">
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
                        @foreach ($project->workGroup ?? [] as $item)
                            <tr>
                                <td>Куратор проекта</td>
                                <td>{{ $item->projCurator }}</td>
                                <td> Стратегическое управление проектом. <br> Выделение ресурсов и разрешения конфликтных ситуаций. <br> Определение уровня прибыли стадий проекта. </td>
                            </tr>
                            <tr>
                                <td>Руководитель проекта</td>
                                <td>{{ $item->projDirector }}</td>
                                <td> Формирование расчетной базы проекта/стадии проекта. <br> Ведение деловой переписки с Заказчиком. <br> Инициация задач и контроль исполнения. <br> Оперативное управление проектом. <br> Регулярный контроль бюджета, сроков реализации стадии проекта.<br> Контроль рисков и инициация выработки корректирующих мероприятий. <br> Формирование отгрузочных документов для закрытия проекта/стадии проекта. <br> Итоговая отчетность. </td>
                            </tr>
                            <tr>
                                <td>Техлид</td>
                                <td>{{ $item->techlid }}</td>
                                <td> Выработка технических решений в рамках реализации проекта. <br> Техническое сопровождение проекта. <br> Выполнение экспертной оценки. <br> Разработка РКД с инициацией соответствующих документов/сущностей в ERP. </td>
                            </tr>
                            <tr>
                                <td>Производство</td>
                                <td>{{ $item->production }}</td>
                                <td> Курирование этапа производства. <br> Контроль бюджета производимого оборудования. <br> Контроль сроков производства. <br> Контроль ресурса производственного блока. <br> Доклад о статусе производства. <br> Создание соответсвующих документов/сущностей в ERP. <br> Инициация закупа. </td>
                            </tr>
                            <tr>
                                <td>Снабжение</td>
                                <td>{{ $item->supply }}</td>
                                <td> Обеспечение проекта необходимыми ТМЦ. <br> Доклад о статусе закупа. <br> Создание соответсвующих документов/сущностей в ERP. </td>
                            </tr>
                            <tr>
                                <td>Логист</td>
                                <td>{{ $item->logistics }}</td>
                                <td> Обеспечение доставки оборудования заказчику в установленные сроки. </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-3">
                <h4 class="text-center mb-3">Организационная структура проекта</h4>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('/images/org_structure.png') }}" alt="Организационная структура проекта">
                </div>
                <a class="btn float-end" href="/images/org_structure.png" download="org_structure"><i
                        class="fa fa-download me-2"></i>Скачать</a>
            </div>
    </div>
</div>
<div class="d-flex gap-3 mt-5">
    <a href="{{ route('update-realization', ['id' => $project->id, 'tab' => 'realization']) }}"><button class="btn btn-primary">Редактировать</button></a>
</div>


@else
    <a href="{{ route('realization-create', $project->id) }}" class="btn btn-primary" target="_blank">Добавить реализацию</a>
@endif

