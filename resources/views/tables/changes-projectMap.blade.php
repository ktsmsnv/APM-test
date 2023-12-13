@if (
    $project->changes()->exists() &&
        $project->changes->first() &&
        $project->basicReference()->exists() &&
        $project->basicReference->first())
    {{-- если изменения существуют и реализация существует --}}
    <div class="mb-3">
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
            <tbody>
                @foreach ($project->changes ?? [] as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->project_num }}</td>
                        <td>{{ $item->contractor }}</td>
                        <td>{{ $item->contract_num }}</td>
                        <td>{{ $item->change }}</td>
                        <td>{{ $item->impact }}</td>
                        <td>{{ $item->stage }}</td>
                        <td>{{ $item->corrective }}</td>
                        <td>{{ $item->responsible }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="editChanges btn btn-xs btn-info" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editChanges" data-id="{{ $item->id }}"><i
                                        class="fa-solid fa-edit"></i></a>
                                <a class="deleteChanges btn btn-xs btn-danger" href="#" data-bs-toggle="modal"
                                    data-bs-target="#confirmationModal" data-id="{{ $item->id }}"><i
                                        class="fa-solid fa-trash-can"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex gap-3 mt-5">
        <a href="{{ route('update-changes', $project->id) }}"><button class="btn btn-primary">РЕДАКТИРОВАТЬ
                ВСЕ</button></a>
    </div>

    {{-- Модальное окно редактирования риска --}}
    <div class="modal fade" id="editChanges" tabindex="-1" role="dialog" aria-labelledby="editChangesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('changes-update-submit', $project->id) }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editChangesLabel">Редактирование изменений"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

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
    // Capture row data and populate modal fields
    $(document).ready(function() {
        $('.editChanges').click(function() {
            // Get the row data attributes
            let projectNum = $(this).closest('tr').find('td:eq(1)').text().trim();
            let contractor = $(this).closest('tr').find('td:eq(2)').text().trim();
            let contractNum = $(this).closest('tr').find('td:eq(3)').text().trim();
            let change = $(this).closest('tr').find('td:eq(4)').text().trim();
            let impact = $(this).closest('tr').find('td:eq(5)').text().trim();
            let stage = $(this).closest('tr').find('td:eq(6)').text().trim();
            let corrective = $(this).closest('tr').find('td:eq(7)').text().trim();
            let responsible = $(this).closest('tr').find('td:eq(8)').text().trim();

            // Populate modal fields with data
            $('#edit_project_num').val(projectNum);
            $('#edit_contractor').val(contractor);
            $('#edit_contract_num').val(contractNum);
            $('#edit_change').val(change);
            $('#edit_impact').val(impact);
            $('#edit_stage').val(stage);
            $('#edit_corrective').val(corrective);
            $('#edit_responsible').val(responsible);

            // Open the modal
            $('#editChanges').modal('show');
        });
    });
</script>
