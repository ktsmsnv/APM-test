@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">Реестр КП</h1>
        <div class="card">
            <div class="card-body">
                <table id="equipment-datatable" class="display nowrap table" style="width:100%">
                    <thead>
                        <tr>
                            <th>№ исходящего</th>
                            <th>Дата</th>
                            <th>Наименование организации</th>
                            <th>Кому</th>
                            <th>Отправитель</th>
                            <th>Сумма (руб. c НДС)</th>
                            <th>№ закупки</th>
                            <th>Примечания</th>
                            <th>Документ</th>
                            <th>Доп. файлы</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($RegReestrKP as $item)
                            <tr data-id="{{ $item->id }}">
                                <td>{{ $item->numIncoming }}</td>
                                <td>{{ date('d.m.Y', strtotime($item->date)) }}</td>
                                <td>{{ $item->orgName }}</td>
                                <td>{{ $item->whom }}</td>
                                <td>{{ $item->sender }}</td>
                                <td>{{ $item->amountNDS }}</td>
                                <td>{{ $item->purchNum }}</td>
                                <td>{{ $item->note }}</td>
                                <td>
                                    @if ($item->word_file)
                                        <a href="{{ route('download-kp', ['id' => $item->id]) }}"
                                            download>{{ $item->original_file_name }}</a>
                                    @else
                                        Нет файла
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $additionalFiles = $item->additionalFiles; // Получаем дополнительные файлы для текущей записи
                                    @endphp
                                    @if ($additionalFiles->count() > 0)
                                        <ul>
                                            @foreach ($additionalFiles as $file)
                                                <li>
                                                    <a href="{{ route('download-kpAdditional', ['id' => $file->id]) }}"
                                                        download>{{ $file->original_file_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        Нет дополнительных файлов
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info me-2 editKPButton" href="#" data-bs-toggle="modal"
                                        data-bs-target="#editKPModal" data-id="{{ $item->id }}"
                                        data-kp-id="{{ $item->id }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>

                                    <a class="btn btn-xs btn-danger" href="#" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteKP" data-id="{{ $item->id }}"><i
                                            class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editKPModal" tabindex="-1" aria-labelledby="editKPModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editKPFormModal" method="post" action="{{ route('reestr-kp.update', ['id' => $item->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKPModalLabel">Редактирование коммерческого предложения
                            {{ $item->numIncoming }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Скрытое поле для идентификатора выбранной записи -->
                        <input type="hidden" id="selectedRecordId">
                        <!-- Поля для редактирования -->
                        <div class="mb-3">
                            <div class="form-group mb-3">
                                <label for="orgName">Наименование организации:</label>
                                <input type="text" class="form-control" name="orgName" id="orgName"
                                    value="{{ $item->orgName }}" placeholder="Введите наименование организации" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="whom">Кому:</label>
                                <input type="text" class="form-control" name="whom" id="whom"
                                    value="{{ $item->whom }}" placeholder="Введите отправителя" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="sender">Отправитель:</label>
                                <input type="text" class="form-control" name="sender" id="sender"
                                    value="{{ $item->sender }}" placeholder="Введите отправителя" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="amountNDS">Сумма в НДС:</label>
                                <input type="text" class="form-control" name="amountNDS" id="amountNDS"
                                    value="{{ $item->amountNDS }}" placeholder="Введите сумму в НДС" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="purchNum">№ закупки:</label>
                                <input type="text" class="form-control" name="purchNum" id="purchNum"
                                    value="{{ $item->purchNum }}" placeholder="Введите номер закупки" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="purchNum">Дата:</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    value="{{ $item->date }}" placeholder="Выберите дату" required>
                            </div>
                            <!-- Поле для замены файла Word -->
                            <span>Документ КП:</span>
                            <div class="form-group mb-5" id="wordFileRow">
                                <div>
                                    @if ($item->word_file)
                                        <a href="{{ route('download-kp', ['id' => $item->id]) }}" download
                                            class="me-3">{{ $item->original_file_name }}</a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            id="replaceWordFileButton">Заменить файл</button>
                                        <button type="button" class="btn btn-sm btn-warning"
                                            id="deleteWordFileButton">Удалить файл</button>
                                        <input type="hidden" name="delete_word_file" id="deleteWordFile"
                                            value="0">
                                        <input type="file" class="form-control" name="word_file" id="wordFile"
                                            style="display: none;">
                                    @else
                                        Нет файла
                                    @endif
                                </div>
                                <input type="file" class="form-control" name="word_file" id="wordFile">
                            </div>

                            <!-- Поле для замены дополнительных файлов -->
                            <span>Дополнительные файлы:</span>
                            <div class="form-group mb-4" id="additionalFiles">
                                @if ($additionalFiles->count() > 0)
                                    <ul>
                                        @foreach ($additionalFiles as $file)
                                            <li class="mb-2">
                                                <a href="{{ route('download-kpAdditional', ['id' => $file->id]) }}"
                                                    download class="me-3">{{ $file->original_file_name }}</a>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger replaceAdditionalFileButton"
                                                    data-id="{{ $file->id }}">Заменить файл</button>
                                                <input type="hidden" name="replace_additional_file_id"
                                                    id="replaceAdditionalFileId" value="">
                                                <button type="button"
                                                    class="btn btn-sm btn-warning deleteAdditionalFileButton"
                                                    data-id="{{ $file->id }}">Удалить файл</button>
                                                <input type="hidden" name="delete_additional_file_id"
                                                    id="deleteAdditionalFileId" value="">
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    Нет дополнительных файлов
                                @endif
                                <input type="file" class="form-control d-none" name="additional_files[]"
                                    id="additionalFiles" multiple>
                            </div>

                            <!-- Поле для добавления новых дополнительных файлов -->
                            <div class="form-group mb-3">
                                <label for="additionalFilesNew">Добавить новые дополнительные файлы:</label>
                                <input type="file" class="form-control" name="additional_files[]"
                                    id="additionalFilesNew" multiple>
                            </div>
                        </div>
                    </div>
                    <!-- Кнопки -->
                    <div class="modal-footer d-flex justify-content-between">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        </div>
                        <button type="button" class="btn btn-danger" id="deleteKPButton">Удалить КП</button>
                        <input type="hidden" name="delete_offer" id="deleteOffer" value="0">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                columnDefs: [{
                    width: "10%",
                    targets: 0
                }],
                pageLength: 15, // Количество записей на странице по умолчанию
                lengthMenu: [15, 35, 50, 100, -1], // Выбор количества записей
                language: {
                    search: 'Поиск:',
                    info: 'Показано с _START_ по _END_ из _TOTAL_ записей',
                    infoEmpty: 'Показано с 0 по 0 из 0 записей',
                    infoFiltered: '(отфильтровано из _MAX_ записей)',
                    lengthMenu: 'Показать _MENU_ записей',
                    paginate: {
                        next: 'Следующая',
                        previous: 'Предыдущая',
                    },
                },
                initComplete: function() {
                    var select = $('select[name="equipment-datatable_length"]');
                    select.find('option[value="-1"]').text('Все');
                },
            });


            $(document).on('click', '.editKPButton', function() {
                var id = $(this).data('id');
                var kpId = $(this).data('kp-id');
                $('#selectedRecordId').val(id);

                // AJAX запрос для получения данных выбранной записи
                $.ajax({
                    url: '/get-kp-details/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response)
                        // Заполнение полей формы данными из ответа
                        $('#orgName').val(response.orgName);
                        $('#whom').val(response.whom);
                        $('#sender').val(response.sender);
                        $('#amountNDS').val(response.amountNDS);
                        $('#purchNum').val(response.purchNum);
                        $('#date').val(response.date);

                        // Вывод файла word_file
                        if (response.wordFile) {
                            $('#wordFileRow').html('<a href="' + response.wordFile.url +
                                '" download>' + response.wordFile.name + '</a>' +
                                '<button type="button" class="btn btn-sm btn-danger ms-3" id="replaceWordFileButton">Заменить файл</button>' +
                                '<button type="button" class="btn btn-sm btn-warning  ms-3" id="deleteWordFileButton">Удалить файл</button>' +
                                '<input type="hidden" name="delete_word_file" id="deleteWordFile" value="0">' +
                                '<input type="file" class="form-control d-none" name="word_file" id="wordFile">'
                            );
                        } else {
                            $('#wordFileRow').html('Нет файла');
                        }

                        // Вывод дополнительных файлов
                        if (response.additionalFiles.length > 0) {
                            var additionalFilesHtml = '';
                            response.additionalFiles.forEach(function(file) {
                                additionalFilesHtml += '<li><a href="' + file.url +
                                    '" download>' + file.name + '</a>' +
                                    '<button type="button" class="btn btn-sm btn-danger ms-3 mb-3 replaceAdditionalFileButton" data-file-id="' +
                                    file.id + '">Заменить файл</button>' +
                                    '<input type="hidden" name="replace_additional_file_id" class="replaceAdditionalFileId" value="' +
                                    file.id + '">' +
                                    '<button type="button" class="btn btn-sm btn-warning  ms-3 mb-3 deleteAdditionalFileButton" data-file-id="' +
                                    file.id + '">Удалить файл</button>' +
                                    '<input type="hidden" name="delete_additional_file_id" class="deleteAdditionalFileId" value="' +
                                    file.id + '"></li>';
                            });
                            $('#additionalFiles').html(additionalFilesHtml);
                        } else {
                            $('#additionalFiles').html('<li>Нет дополнительных файлов</li>');
                        }
                    },
                    error: function() {
                        alert('Ошибка при загрузке данных');
                    }
                });
            });

            // Обработчик события для замены файла word
            $('#editKPFormModal').on('click', '#replaceWordFileButton', function() {
                // Получаем файл из элемента
                var file = $('#wordFile')[0].files[0];
                // Проверяем, был ли выбран файл
                if (file) {
                    var id = $('#selectedRecordId').val();
                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('_method', 'PUT');
                    $.ajax({
                        url: '/reestr-kp/' + id,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        // Обработка успешного обновления файла
                        success: function(response) {
                            // Скрываем наименование старого файла
                            $('#wordFile').siblings('a').hide();
                            // Показываем наименование нового файла
                            $('#wordFile').siblings('a').text(response.name).show();
                        },
                        error: function() {
                            alert('Ошибка при замене файла');
                        }
                    });
                } else {
                    alert('Файл не выбран.');
                }
            });


            $(document).on('click', '#deleteWordFileButton', function() {
                var id = $('#selectedRecordId').val();

                $.ajax({
                    url: '/reestr-kp/' + id,
                    type: 'POST',
                    data: {
                        _method: 'PUT',
                        delete_word_file: true
                    },
                    // Обработка успешного удаления файла
                    success: function(response) {
                        // Скрываем поле с удаленным файлом
                        $('#wordFileRow').find('a').hide();
                        // Показываем текст "Нет файла"
                        $('#wordFileRow').find('span').text('Нет файла').show();
                    },
                    error: function() {
                        alert('Ошибка при удалении файла');
                    }
                });
            });

            // Удаление всего коммерческого предложения
            $(document).on('click', '#deleteKPButton', function() {
                // Запрос подтверждения действия
                if (confirm('Вы уверены, что хотите удалить коммерческое предложение?')) {
                    var id = $('#selectedRecordId').val();
                    $.ajax({
                        url: '/reestr-kp/' + id,
                        type: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            // Обработка успешного удаления коммерческого предложения
                        },
                        error: function() {
                            alert('Ошибка при удалении коммерческого предложения');
                        }
                    });
                }
            });

            // Замена существующего дополнительного файла
            $(document).on('click', '.replaceAdditionalFileButton', function() {
                var fileId = $(this).data('id');
                var formData = new FormData();
                formData.append('additional_files', $('#additionalFiles')[0].files[0]);
                formData.append('replace_additional_file_id', fileId);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: '/reestr-kp/' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Обработка успешного обновления дополнительного файла
                        var fileElement = $('li[data-id="' + fileId + '"]');
                        fileElement.find('a').text(response.name);
                    },
                    error: function() {
                        alert('Ошибка при замене дополнительного файла');
                    }
                });
            });

            // Удаление существующего дополнительного файла
            $(document).on('click', '.deleteAdditionalFileButton', function() {
                var fileId = $(this).data('id');

                $.ajax({
                    url: '/reestr-kp/' + id,
                    type: 'POST',
                    data: {
                        _method: 'PUT',
                        delete_additional_file_id: fileId
                    },
                    success: function(response) {
                        // Обработка успешного удаления дополнительного файла
                        var fileElement = $('li[data-id="' + fileId + '"]');
                        fileElement.remove();
                    },
                    error: function() {
                        alert('Ошибка при удалении дополнительного файла');
                    }
                });
            });


            // Добавление новых дополнительных файлов
            $(document).on('change', '#additionalFilesNew', function() {
                var id = $('#selectedRecordId').val();
                var formData = new FormData();
                var files = $('#additionalFilesNew')[0].files;

                for (var i = 0; i < files.length; i++) {
                    formData.append('additional_files[]', files[i]);
                }

                formData.append('_method', 'PUT');

                $.ajax({
                    url: '/reestr-kp/' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    // Обработка успешной загрузки дополнительных файлов
                    success: function(response) {
                        // Очищаем список загруженных файлов
                        $('#additionalFiles').val('');
                        // Удаляем существующие элементы списка
                        $('#additionalFilesList').empty();
                        // Перебираем список загруженных файлов и добавляем их в список
                        response.additionalFiles.forEach(function(file) {
                            $('#additionalFilesList').append(
                                '<li><a href="' + file
                                .url + '">' + file.name + '</a></li>');
                        });
                    },
                    error: function() {
                        alert('Ошибка при загрузке дополнительных файлов');
                    }
                });
            });
        });
    </script>
@endsection
