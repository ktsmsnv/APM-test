@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">Добавление СМК для {{ $project->projNum }}</h1>
        <form action="{{ route('smk-store', $project->id) }}" method="post" class="smk__create">
            @csrf
            {{-- СМК --}}
            <div class="mb-5">
                <table id="smk__main-table" class="">
                    <tbody>
                        <tr>
                            <th class="head">Критерии результативности процесса</th>
                            <th class="head">Описание критерия</th>
                            <th class="head">Оценка выполнения (Фi)</th>
                            <th class="head">Плановый показатель (Ki)</th>
                        </tr>
                        <tr>
                            <th class="cost">Стоимость проекта</th>
                            <td>Увеличение плановой себестоимости на: <br>
                                –  5% <br>
                                –  6-25% <br>
                                –  26-40% <br>
                                –  более 41%
                            </td>
                            <td> <br>
                                1 <br>
                                0,8 <br>
                                0,6 <br>
                                0
                            </td>
                            <td><input type="text" class="form-control" name="project_cost_ki" id="project_cost_ki"
                                placeholder="Введите стоимость проекта"></td>
                        </tr>
                        <tr>
                            <th class="period">Сроки реализации проекта</th>
                            <td>Проект реализуется в договорные сроки или не более 25% <br>
                                Увеличение от договорных сроков на: <br>
                                –   26-40% <br>
                                –   41-70% <br>
                                –   более 71%
                            </td>
                            <td>
                                1<br>
                                <br>
                                0,8 <br>
                                0,6 <br>
                                0
                            </td>
                            <td><input type="text" class="form-control" name="project_period_ki" id="project_period_ki"
                                placeholder="Введите сроки реализации проекта"></td>
                        </tr>
                        <tr>
                            <th class="quality">Качество реализации проекта</th>
                            <td>Принятые официальные претензии/рекламации по проекту: <br>
                                –  0 <br>
                                –  1-2 замечания <br>
                                –  3 замечания <br>
                                –  4 и более замечаний
                            </td>
                            <td>
                                <br>
                                1 <br>
                                0,8 <br>
                                0,6 <br>
                                0
                            </td>
                            <td><input type="text" class="form-control" name="project_quality_ki" id="project_quality_ki"
                                placeholder="Введите качество реализации проекта"></td>
                        </tr>
                    </tbody>
                </table>
                <small>* Для формирования взвешенной оценки в отчетном периоде необходимо проанализировать каждую реализуемую спецификацию в отчетном периоде и вывести <br>
                    среднестатистическое значение по формуле <br>
                    Фi=Сумма значений показателя по всем спецификациям в отчетном периоде/количество спецификаций в отчетном периоде</small>
            </div>
             {{-- Квартал --}}
            <div class="mb-5">
                <h5 class="mb-3">Квартал №</h5>
                <table id="smk__sub-table" class="">
                    <thead>
                        <tr>
                            <th>№ Спецификации</th>
                            <th>Стоимость проекта</th>
                            <th>Сроки реализации проекта</th>
                            <th>Качество реализации проекта</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Сохранить</button>
        </form>
    </div>

@endsection
