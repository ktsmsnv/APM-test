@extends('layouts.app')
@section('title')
    {{ "APM | КСТ | Редактирование изменений для карты проекта $project->projNum" }}
@endsection
@section('content')
    <div class="container updateProject">
        <h1 class="mb-5">Редактирование изменений для карты проекта {{ $project->projNum }}</h1>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-realization-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-realization" type="button" role="tab" aria-controls="pills-realization"
                    aria-selected="false">Изменения</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <form action="{{ route('changes-update-submit', $project->id) }}" method="post">
                @csrf
                {{-- изменения редактирование --}}
                <div class="tab-pane fade show active" id="pills-changes" role="tabpanel" aria-labelledby="pills-changes-tab">
                    <div class="changes-add pt-5">
                        <table id="changes-table" class="mb-5">
                            <thead>
                                <tr>
                                    <th>Проект</th>
                                    <th>Контрагент</th>
                                    <th>№ Договора/Спецификации</th>
                                    <th>Изменение</th>
                                    <th>Влияние</th>
                                    <th>Этап</th>
                                    <th>Корректирующие действия</th>
                                    <th>Ответственный</th>
                                </tr>
                            </thead>
                            <tbody id="changes-inputs" class="input-field">
                                @foreach ($project->changes ?? [] as $index => $change)
                                    <tr>
                                        <td>

                                            <input type="text" class="form-control d-none"
                                                name="changes[{{ $index + 1 }}][id]" value="{{ $change->id }}"
                                                class="input_editable" readonly>

                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][project_num]"
                                                    value="{{ $change->project_num }}" class="input_editable" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][contractor]"
                                                    value="{{ $change->contractor }}" class="input_editable" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][contract_num]"
                                                    value="{{ $change->contract_num }}" class="input_editable" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][change]"
                                                    value="{{ $change->change }}" class="input_editable">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][impact]"
                                                    value="{{ $change->impact }}" class="input_editable">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][stage]"
                                                    value="{{ $change->stage }}" class="input_editable">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][corrective]"
                                                    value="{{ $change->corrective }}" class="input_editable">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-3">
                                                <input type="text" class="form-control"
                                                    name="changes[{{ $index + 1 }}][responsible]"
                                                    value="{{ $change->responsible }}" class="input_editable" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button id="addMore-changes" class="btn btn-secondary">Добавить еще изменение</button>
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


                $("#addMore-changes").click(function(event) {
                    event.preventDefault();
                    newIndex++;

                    const newRow = $(getHtml(newIndex));
                    newRow.appendTo(`#changes-inputs`);
                    newRow.find('.delete-btn').on('click', function() {
                        newRow.remove();
                    });
                });
                // функция возвращающая html в секцию
                function getHtml(index) {
                    return `<tr>
                                <td>
                                    <input type="hidden" class="form-control" name="changes[${index}][id]" value="" class="input_editable">
                                    <input type="text" class="form-control" name="changes[${index}][project_num]"  id="project_num" value="{{ $project->projNum }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="changes[${index}][contractor]" id="contractor" value="{{ $project->contractor }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="changes[${index}][contract_num]" id="contract_num"  value="{{ $project->basicInfo->first()->contract_num }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="changes[${index}][change]" id="change"  placeholder="Введите изменение">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="changes[${index}][impact]" id="impact"  placeholder="Введите влияние">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="changes[${index}][stage]" id="stage" placeholder="Введите этап">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="changes[${index}][corrective]" id="corrective" placeholder="Введите корректирующие действия">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="changes[${index}][responsible]" id="responsible"  value="{{ $project->basicReference->first()->projManager }}" readonly>
                                </td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-times"></i></button></td>
                            </tr>`
                }

            });
        </script>
    @endsection
