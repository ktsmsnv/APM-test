@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">Хранилище договоров</h1>
        <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addContracts">Загрузить договор(-ы)</a>
        <div class="card mt-2">

            <div class="card-body">
                <div class="card__main">
                    <div class="tab-content" id="myTabContent">
                        <div class="select">
                            <select class="form-control d-none" id="locale">
                                <option value="ru-RU">ru-RU</option>
                            </select>
                        </div>
                        <!-- Содержимое первой вкладки -->
                        <div class="tab-pane fade show active" id="contractStorage" role="tabpanel" aria-labelledby="contractStorage-tab">
                            <div class="card-body">
                                <table id="contractStorageTable" data-toolbar="#toolbar" data-search="true" data-show-refresh="true"
                                       data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true"
                                       data-show-columns-toggle-all="true" data-detail-view="true" data-show-export="true"
                                       data-click-to-select="true" data-detail-formatter="detailFormatter"
                                       data-minimum-count-columns="12" data-show-pagination-switch="true" data-pagination="true"
                                       data-id-field="id" data-response-handler="responseHandler">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Наименование договора</th>
                                        <th>Контрагент</th>
                                        <th>Дата заключения</th>
                                        <th>Дата окончания</th>
                                        <th>Дней осталось</th>
                                        <th>Договор (файл)</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($contractStorage as $item)
                                        <tr class="editable-row" data-id="{{ $item->id }}">
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->contractName }}</td>
                                            <td>{{ $item->contractor }}</td>
                                            <td>{{ date('d.m.Y', strtotime($item->dateStart)) }}</td>
                                            <td>{{ date('d.m.Y', strtotime($item->dateEnd)) }}</td>
                                            <td>{{ $item->daysLeft }}</td>
                                            <td>
                                                @php
                                                    $additionalFilesCS = $item->additionalFilesCS;
                                                @endphp
                                                @if ($additionalFilesCS->count() > 0)
                                                    <ul>
                                                        @foreach ($additionalFilesCS as $file)
                                                            <li>
                                                                <a href="{{ route('download-csAdditional', ['id' => $file->id]) }}"
                                                                   download>{{ $file->original_file_name_cs }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    Нет дополнительных файлов
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a class="btn btn-xs btn-info me-2 editCSModal" href="#" data-bs-toggle="modal"
                                                       data-bs-target="#editCSModal" data-id="{{ $item->id }}"
                                                       data-cs-id="{{ $item->id }}">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>

                                                    <a class="btn btn-xs btn-danger deleteCSButton" href="#" data-bs-toggle="modal"
                                                       data-bs-target="#confirmDeleteCS" data-id="{{ $item->id }}"><i
                                                                class="fa-solid fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if ($contractStorage->isNotEmpty())
                        <div class="modal fade" id="editCSModal" tabindex="-1" aria-labelledby="editCSModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="editCSFormModal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCSModalLabel">Редактирование коммерческого предложения
                                                <span id="contractNameDisplay"></span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Скрытое поле для идентификатора выбранной записи -->
                                            <input type="hidden" name="selectedRecordId" id="selectedRecordId" value="">
                                            <!-- Поля для редактирования -->
                                            <div class="mb-3">
                                                <div class="form-group mb-3">
                                                    <label for="contractName">Наименование договора:</label>
                                                    <input type="text" class="form-control" name="contractName" id="contractName"
                                                           value="{{ $item->contractName }}" placeholder="Введите наименование договора"
                                                           required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="contractor">Контрагент:</label>
                                                    <input type="text" class="form-control" name="contractor" id="contractor"
                                                           value="{{ $item->contractor }}" placeholder="Введите контрагента"required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="dateStart">Дата заключения:</label>
                                                    <input type="date" class="form-control" name="dateStart" id="dateStart"
                                                           value="{{ $item->dateStart }}" placeholder="Введите дату заключения" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="dateEnd">Дата окончания:</label>
                                                    <input type="date" class="form-control" name="dateEnd" id="dateEnd"
                                                           value="{{ $item->dateEnd }}" placeholder="Введите дату окончания" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="daysLeft">Дней осталось:</label>
                                                    <input type="text" class="form-control" name="daysLeft" id="daysLeft"
                                                           value="{{ $item->daysLeft }}" placeholder="Введите кол-во оставшихся дней" required>
                                                </div>
                                                <!-- Поле для замены файлов -->
                                                <span>Файлы договоров:</span>
                                                <div class="form-group mb-4" id="additionalFilesCS">
                                                    @if ($additionalFilesCS->count() > 0)
                                                        <ul>
                                                            @foreach ($additionalFilesCS as $file)
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>

                                                <!-- Поле для добавления новых дополнительных файлов -->
                                                <div class="form-group mb-3">
                                                    <label for="additionalFilesCSNew">Добавить новые дополнительные договоры:</label>
                                                    <input type="file" class="form-control" name="additionalContracts[]"
                                                           id="additionalFilesCSNew" multiple>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Кнопки -->
                                        <div class="modal-footer d-flex justify-content-between">
                                            <div class="d-flex gap-3">
                                                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                            </div>
                                            <a class="btn btn-xs btn-danger deleteCSButton" href="#" data-bs-toggle="modal"
                                               data-bs-target="#confirmDeleteCS" data-id="{{ $item->id }}">
                                                Удалить</a>
                                            <input type="hidden" name="delete_offer" id="deleteOffer" value="0">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="modal fade" id="confirmDeleteCS" tabindex="-1" aria-labelledby="confirmDeleteCSLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteCSLabel">Подтверждение удаления договора
                                            {{ $item->numIncoming }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Вы уверены, что хотите удалить этот договор?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                        <button type="button" class="btn btn-danger" id="confirmDelete">Удалить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var $table = $('#contractStorageTable');
            initTable($table);
            // инициализация таблицы и ее настроек
            function initTable($table) {
                $table.bootstrapTable({
                    locale: $('#locale').val(),
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 5,
                    pageList: [5, 15, 50, 'all'],
                    columns: [
                        {
                        field: 'id',
                        title: '№',
                        valign: 'middle',
                        sortable: true,
                        },
                        {
                            field: 'contractName',
                            title: 'Наименование договора',
                            valign: 'middle',
                            sortable: true,
                        },
                        {
                            field: 'contractor',
                            title: 'Контрагент',
                            valign: 'middle',
                            sortable: true
                        },
                        {
                            field: 'dateStart',
                            title: 'Дата заключения',
                            valign: 'middle',
                            sortable: true
                        },
                        {
                            field: 'dateEnd',
                            title: 'Дата окончания',
                            valign: 'middle',
                            sortable: true
                        },
                        {
                            field: 'daysLeft',
                            title: 'Дней осталось',
                            valign: 'middle',
                            sortable: true
                        }
                    ]
                });
            }
            // Передача данных
            $(document).on('click', '.editCSModal', function() {
                var id = $(this).data('id');
                var kpId = $(this).data('kp-id');
                $('#selectedRecordId').val(id);

                // AJAX запрос для получения данных выбранной записи
                $.ajax({
                    url: '/get-cs-details/' + id,
                    type: 'GET',
                    success: function(response) {
                        // console.log(response);
                        // Заполнение полей формы данными из ответа
                        $('#contractNameDisplay').text(response.contractName); // Устанавливаем номер проекта
                        $('#contractName').val(response.contractName);
                        $('#contractor').val(response.contractor);
                        $('#dateStart').val(response.dateStart);
                        $('#dateEnd').val(response.dateEnd);
                        $('#daysLeft').val(response.daysLeft);

                        // Вывод дополнительных файлов
                        var additionalFilesCSHtml = '';
                        if (response.additionalFilesCS.length > 0) {
                            $.each(response.additionalFilesCS, function(index, file) {
                                additionalFilesCSHtml += '<li class="mb-2">';
                                additionalFilesCSHtml += '<a href="' + file.url +
                                    '" download id="additionalFileCSName_' + file.id +
                                    '">' + file.name + '</a>';
                                additionalFilesCSHtml += '<label for="additionalFileCS_' +
                                    file.id + '" class="btn btn-sm btn-danger ms-3">';
                                additionalFilesCSHtml += 'Заменить файл';
                                additionalFilesCSHtml +=
                                    '<input type="file" class="form-control additionalFileCS" name="additionalFileCS_' +
                                    file.id + '" id="additionalFileCS_' + file.id +
                                    '" data-file-id="' + file.id +
                                    '" style="display: none;">';
                                additionalFilesCSHtml += '</label>';
                                // Добавляем кнопку удаления файла
                                additionalFilesCSHtml +=
                                    '<button class="btn btn-sm btn-secondary ms-3 deleteFileButton" data-file-id="' +
                                    file.id + '">Удалить файл</button>';
                                additionalFilesCSHtml += '</li>';
                            });
                        } else {
                            additionalFilesCSHtml = 'Нет дополнительных файлов';
                        }
                        $('#additionalFilesCS').html(additionalFilesCSHtml);
                    },
                    error: function() {
                        alert('Ошибка при загрузке данных');
                    }
                });
            });
            // Обработчик события изменения дополнительного файла
            $(document).on('change', '.additionalFileCS', function() {
                var file = this.files[0];
                var fileId = $(this).data('file-id'); // Получаем ID файла
                var formData = new FormData();
                formData.append('additionalContracts', file);
                formData.append('_method', 'PUT'); // Добавляем вручную метод PUT

                // Получаем токен CSRF из мета-тега
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                // Устанавливаем токен CSRF в заголовке запроса
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    url: '/contract-storage/additional-files/' +
                        fileId, // Используем ID файла для замены соответствующего файла
                    type: 'POST', // Используем POST для замены файла
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // В случае успешной замены файла обновляем его имя на странице
                        $('#additionalFileCSName_' + fileId).text(file.name);
                    },
                    error: function() {
                        alert('Ошибка при замене дополнительного файла');
                    }
                });
            });

            // Обработчик события для кнопки удаления дополнительного файла
            $(document).on('click', '.deleteFileButton', function() {
                event.preventDefault();
                var fileId = $(this).data('file-id'); // Получаем ID файла
                // Отправляем запрос на сервер для удаления файла
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/delete-cs-additionalfile/' + fileId,
                    type: 'DELETE',
                    success: function(response) {
                        $('#additionalFileCSName_' + fileId).closest('li')
                            .remove(); // Удаляем соответствующий элемент из DOM
                    },
                    error: function() {
                        alert('Ошибка при удалении файла');
                    }
                });
            });

            // Обработчик события отправки формы
            $('#editCSFormModal').on('submit', function(event) {
                event.preventDefault(); // Предотвращаем отправку формы по умолчанию

                // Создаем объект FormData и добавляем данные формы
                var formData = new FormData(this);

                // Добавляем токен CSRF в данные формы
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                formData.append('_token', csrfToken);

                // Получаем все выбранные дополнительные файлы и добавляем их в FormData
                $('.additionalFileCS').each(function() {
                    var files = $(this)[0].files;
                    for (var i = 0; i < files.length; i++) {
                        formData.append('additionalContracts[]', files[i]);
                    }
                });

                // Отправляем ID выбранной записи вместе с данными формы
                var selectedRecordId = $('#selectedRecordId').val();
                formData.append('selectedRecordId', selectedRecordId);

                // Отправляем AJAX запрос
                $.ajax({
                    // url: $(this).attr('action'),
                    url: '/contract-storage/' + selectedRecordId,
                    type: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Обработка успешного ответа
                        // console.log(response);
                        window.location.href = '/contract-storage';
                    },
                    error: function(xhr, status, error) {
                        // Обработка ошибок
                        console.error(xhr.responseText);
                    }
                });
            });

            // Удаление договора (cs)
            let deleteItemId;
            // Получаем id Договора при открытии модального окна
            $('#confirmDeleteCS').on('show.bs.modal', function(event) {
                deleteItemId = $(event.relatedTarget).data('id');
            });
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Обработчик кнопки удаления
            $('#confirmDelete').click(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    method: 'DELETE',
                    url: '/delete-cs/' + deleteItemId,
                    success: function(response) {
                        // Обновление страницы или другие действия по желанию
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Вывод сообщения об ошибке или другие действия по желанию
                    }
                });
                $('#confirmDeleteCS').modal('hide');
            });

        });


    </script>

    {{-- Модальное окно загрузки договора(-ов) --}}
    <div class="modal fade" id="addContracts" tabindex="-1" aria-labelledby="addContractsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('uploadContracts') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContractsLabel">Загрузка договора(-ов)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="contractName">Наименование договора:</label>
                            <input type="text" class="form-control" name="contractName" id="contractName"
                                   placeholder="Введите наименование договора" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="contractor">Контрагент:</label>
                            <input type="text" class="form-control" name="contractor" id="contractor"
                                   placeholder="Введите контрагента" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="dateStart">Дата заключения:</label>
                            <input type="date" class="form-control" name="dateStart" id="dateStart"
                                   placeholder="Введите дату заключения" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="dateEnd">Дата окончания:</label>
                            <input type="date" class="form-control" name="dateEnd" id="dateEnd"
                                   placeholder="Введите дату окончания" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="daysLeft">Оставшиеся дни:</label>
                            <input type="text" class="form-control" name="daysLeft" id="daysLeft"
                                   placeholder="Введите оставшиеся дни" required="">
                        </div>

{{--                        <div class="form-group mb-3">--}}
{{--                            <label for="additionalContracts">Файл(-ы) Word:</label>--}}
{{--                            <input type="file" class="form-control" name="additionalContracts"--}}
{{--                                   id="additionalContracts" multiple>--}}
{{--                        </div>--}}
                        <div class="form-group mb-3">
                            <label for="additionalContracts">Файл(-ы) Word:</label>
                            <input type="file" class="form-control" name="additionalContracts[]"
                                   id="additionalContracts" multiple>
                        </div>
                    </div>
                    {{-- Кнопки --}}
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Добавить</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
