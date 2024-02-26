* тестовая страница (не работает)
@if ($project && $project->smk_main && $project->smk_main->first())
    {{-- если смк существует --}}
    <div class="mb-3 smk__main-table">
        <tbody>
            @foreach ($project->smk_main ?? [] as $item)
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
                <td>{{ $item->project_cost_ki }}</td>
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
                <td>{{ $item->project_period_ki }}</td>
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
                <td>{{ $item->project_quality_ki }}</td>
            </tr>
            @endforeach
        </tbody>
    </div>
    <div class="d-flex gap-3 mt-5">
        <a href="{{ route('update-smk', ['id' => $project->id, 'tab' => 'smk']) }}"><button
                class="btn btn-primary">РЕДАКТИРОВАТЬ СМК</button></a>
    </div>

    {{-- Модальное окно редактирования смк --}}
    <div class="modal fade" id="editSmk" tabindex="-1" role="dialog" aria-labelledby="editSmkLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('smk-update', $project->id) }}" method="post">
                @csrf
                @method('put')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSmkLabel">Редактирование СМК"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="projectId" value="{{ $project->id }}">

                    </div>
                    {{-- Кнопки --}}
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Модальное окно уведомление подтверждение об удалении записи --}}
    <div class="modal fade" id="confirmationModalSmk" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalSmkLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalSmkLabel">Подтверждение действия</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="projectId" class="modalId" data-id="{{ $project->id }}">
                    Вы уверены что хотите удалить СМК ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteChanges"
                        data-id="{{ $item->id }}">Удалить</button>
                </div>
            </div>
        </div>
    </div>

@else
    <a href="{{ route('smk-create', $project->id) }}" class="btn btn-primary" target="_blank">Сформировать
        СМК</a>

@endif
