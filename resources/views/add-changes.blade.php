@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Добавление изменений для {{ $project->projNum }}</h1>
        <form action="{{ route('changes-store', $project->id) }}" method="post">
            @csrf
            {{-- Изменения --}}
            <div class="changes-add pt-5">
                <table id="changes-table" class="mb-5">
                    <thead>
                        <tr>
                            {{-- <th>№</th> --}}
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
                    <tbody id="changes-inputs">
                        <tr>
                            {{-- <td>
                                    <input type="text" class="form-control" name="changes[0][id]" id="id" readonly>
                                </td> --}}
                            <td>
                                <input type="text" class="form-control" name="changes[0][project_num]" id="project_num"
                                    value="{{ $project->projNum }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="changes[0][contractor]" id="contractor"
                                    value="{{ $project->contractor }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="changes[0][contract_num]" id="contract_num"
                                    value="{{ $project->basicInfo->first()->contract_num }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="changes[0][change]" id="change"
                                    placeholder="Введите изменение">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="changes[0][impact]" id="impact"
                                    placeholder="Введите влияние">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="changes[0][stage]" id="stage"
                                    placeholder="Введите этап">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="changes[0][corrective]" id="corrective"
                                    placeholder="Введите корректирующие действия">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="changes[0][responsible]" id="responsible"
                                    value="{{ $project->basicReference->first()->projManager }}" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button id="addMore-changes" class="btn btn-secondary">Добавить еще изменение</button>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Сохранить</button>
        </form>
    </div>
    <script>
        // добавление доп строк
        let index = 0;
        $(document).ready(function() {
                    $("#addMore-changes").click(function(event) {
                        event.preventDefault();
                        index++;

                        const newRow = $(getHtml(index));
                        newRow.appendTo(`#changes-inputs`);
                        newRow.find('.delete-btn').on('click', function() {
                            newRow.remove();
                        });
                    });
                    // функция возвращающая html в секцию
                    function getHtml() {
                        return `<tr>
                                {{-- <td>
                                    <input type="text" class="form-control" name="changes[${index}][id]" id="id" readonly>
                                </td> --}}
                                <td>
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
