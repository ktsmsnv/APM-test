@if (
    $project->changes()->exists() &&
        $project->changes->first() &&
        $project->basicReference()->exists() &&
        $project->basicReference->first())
    {{-- если изменения существуют и реализация существует --}}
    <div class="mb-3 changes_table">
        <table id="changes-table" class="mb-5">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Проект</th>
                    <th>Контрагент</th>
                    <th>№ Договора/Спецификации</th>
                    <th>Изменение</th>
                    <th>Влияние</th>
                    <th>Этап</th>
                    <th>Корректирующие действия</th>
                    <th>Ответственный</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="changes-inputs">
                @foreach ($project->changes ?? [] as $index => $item)
                    <tr data-project-id="{{ $project->id }}">
                        <td class="changes[{{ $index + 1 }}][id]">{{ $item->id }}</td>
                        <td class="changes[{{ $index + 1 }}][project_num]">{{ $item->project_num }}</td>
                        <td class="changes[{{ $index + 1 }}][contractor]">{{ $item->contractor }}</td>
                        <td class="changes[{{ $index + 1 }}][contract_num]">{{ $item->contract_num }}</td>
                        <td class="changes[{{ $index + 1 }}][change]">{{ $item->change }}</td>
                        <td class="changes[{{ $index + 1 }}][impact]">{{ $item->impact }}</td>
                        <td class="changes[{{ $index + 1 }}][stage]">{{ $item->stage }}</td>
                        <td class="changes[{{ $index + 1 }}][corrective]">{{ $item->corrective }}</td>
                        <td class="changes[{{ $index + 1 }}][responsible]">{{ $item->responsible }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="editChanges btn btn-xs btn-info" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editChanges" data-id="{{ $item->id }}"><i
                                        class="fa-solid fa-edit"></i></a>
                                <a class="deleteChanges btn btn-xs btn-danger" href="#" data-bs-toggle="modal"
                                    data-bs-target="#confirmationModalChanges" data-id="{{ $item->id }}"><i
                                        class="fa-solid fa-trash-can"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('update-changes', ['id' => $project->id, 'tab' => 'changes']) }}"><button
                class="btn btn-secondary">
                Добавить изменения</button></a>
    </div>
    <div class="d-flex gap-3 mt-5">
        <a href="{{ route('update-changes', ['id' => $project->id, 'tab' => 'changes']) }}"><button
                class="btn btn-primary">РЕДАКТИРОВАТЬ
                ВСЕ</button></a>
    </div>

    {{-- Модальное окно редактирования риска --}}
    <div class="modal fade" id="editChanges" tabindex="-1" role="dialog" aria-labelledby="editChangesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('changes-update', $project->id) }}" method="post">
                @csrf
                @method('put')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editChangesLabel">Редактирование изменений"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="projectId" value="{{ $project->id }}">
                        <div class="mb-3">
                            <label for="project_num" class="form-label">Проект</label>
                            <input type="text" class="form-control" name="project_num" id="edit_project_num"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="contractor" class="form-label">Контрагент</label>
                            <input type="text" class="form-control" name="contractor" id="edit_contractor" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="contract_num" class="form-label">№ Договора/Спецификации</label>
                            <input type="text" class="form-control" name="contract_num" id="edit_contract_num"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="change" class="form-label">Изменение</label>
                            <input type="text" class="form-control" name="change" id="edit_change">
                        </div>
                        <div class="mb-3">
                            <label for="impact" class="form-label">Влияние</label>
                            <input type="text" class="form-control" name="impact" id="edit_impact">
                        </div>
                        <div class="mb-3">
                            <label for="stage" class="form-label">Этап</label>
                            <input type="text" class="form-control" name="stage" id="edit_stage">
                        </div>
                        <div class="mb-3">
                            <label for="corrective" class="form-label">Корректирующие действия</label>
                            <input type="text" class="form-control" name="corrective" id="edit_corrective">
                        </div>
                        <div class="mb-3">
                            <label for="responsible" class="form-label">Ответственный</label>
                            <input type="text" class="form-control" readonly name="responsible"
                                id="edit_responsible">
                        </div>

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
    <div class="modal fade" id="confirmationModalChanges" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalChangesLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalChangesLabel">Подтверждение действия</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="projectId" class="modalId" data-id="{{ $project->id }}">
                    Вы уверены что хотите удалить риск "{{ $item->change }}"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteChanges"
                        data-id="{{ $item->id }}">Удалить</button>
                </div>
            </div>
        </div>
    </div>
@elseif($project && $project->totals && $project->totals->isEmpty())    
    <p>Для добавления изменений необходимо заполнить "Расчет" полностью.</p>
    <a href="#" data-bs-toggle="modal" data-bs-target="#addContinueModal" class="btn btn-danger mb-4">
        Продолжить заполнение расчета
    </a>
@elseif (!$project->changes()->exists() && !$project->basicReference()->exists())
    {{-- если отчета и реализации нет --}}
    <h4 class="mb-3">Заполните сначала реализацию</h4>
    <a href="{{ route('realization-create', $project->id) }}"><button class="btn btn-danger">Заполнить
            реализацию</button></a>
@else
    {{-- если только изменений нет --}}
    <a href="{{ route('changes-create', $project->id) }}" class="btn btn-primary" target="_blank">Добавить
        изменения</a>

@endif


<script>
    let existingRows = {{ count($project->changes ?? []) }};
    let newIndex = existingRows;
    $(document).ready(function() {
        $(document).on('click', '.editChanges', function() {
            let changeId = $(this).data('id');
            console.log('Change ID:', changeId);
            let projectNum = $(this).closest('tr').find('td:eq(1)').text().trim();
            let contractor = $(this).closest('tr').find('td:eq(2)').text().trim();
            let contractNum = $(this).closest('tr').find('td:eq(3)').text().trim();
            let change = $(this).closest('tr').find('td:eq(4)').text().trim();
            let impact = $(this).closest('tr').find('td:eq(5)').text().trim();
            let stage = $(this).closest('tr').find('td:eq(6)').text().trim();
            let corrective = $(this).closest('tr').find('td:eq(7)').text().trim();
            let responsible = $(this).closest('tr').find('td:eq(8)').text().trim();


            $('#edit_project_num').val(projectNum);
            $('#edit_contractor').val(contractor);
            $('#edit_contract_num').val(contractNum);
            $('#edit_change').val(change);
            $('#edit_impact').val(impact);
            $('#edit_stage').val(stage);
            $('#edit_corrective').val(corrective);
            $('#edit_responsible').val(responsible);

            $('form').attr('action', '/project-maps/changes-update/' + changeId + '#changes');

            $('#editChanges').modal('show');
        });

        // Подтверждение удаления
        let itemIdToDelete;
        $('#confirmationModalChanges').on('show.bs.modal', function(event) {
            itemIdToDelete = $(event.relatedTarget).data('id');
            projId = $(".modalId").data('id');
        });

        $('#confirmDeleteChanges').click(function() {
            console.log('Item ID to delete:', itemIdToDelete);
            $.ajax({
                method: 'GET',
                url: `/project-maps/changes-delete/${itemIdToDelete}`,
                success: function(data) {
                    toastr.success('Запись была удалена', 'Успешно');
                    let projectId = data.projectId;
                    setTimeout(function() {
                        // window.location.reload(1);
                        window.location.href =
                            `/project-maps/all/${projId}/#changes`;
                    }, 2000);
                },
                error: function(error) {
                    if (error.responseText) {
                        toastr.error(error.responseText, 'Ошибка');
                    } else {
                        toastr.error('Ошибка удаления', 'Ошибка');
                    }
                }
            });
            $('#confirmationModalChanges').modal('hide');
        });

    });
</script>
