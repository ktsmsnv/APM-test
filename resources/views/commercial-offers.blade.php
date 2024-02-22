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
                                {{-- <td>{{ $item->numIncoming }}</td> --}}
                                <td><a
                                        href="{{ route('project-data-one', ['id' => $item->project->id, 'tab' => 'calculation']) }}">{{ $item->numIncoming }}</a>
                                </td>
                                <td>{{ date('d.m.Y', strtotime($item->date)) }}</td>
                                <td>{{ $item->orgName }}</td>
                                <td>{{ $item->whom }}</td>
                                <td>{{ $item->sender }}</td>
                                <td>{{ $item->amountNDS }}</td>
                                <td>{{ $item->purchNum }}</td>
                                {{-- <td>
                                    {{ $item->note }}
                                </td> --}}
                                <td class="editable" data-field="note" data-id="{{ $item->id }}" contenteditable>
                                    {{ $item->note }}</td>
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
                                        $additionalFiles = $item->additionalFiles; 
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

                                    <a class="btn btn-xs btn-danger deleteKPButton" href="#" data-bs-toggle="modal"
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

    @if ($RegReestrKP->isNotEmpty())
        <div class="modal fade" id="editKPModal" tabindex="-1" aria-labelledby="editKPModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                {{-- <form id="editKPFormModal" method="post" action="{{ route('reestr-kp.update', ['id' => $item->id]) }}"
                enctype="multipart/form-data"> --}}
                <form id="editKPFormModal" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKPModalLabel">Редактирование коммерческого предложения
                                <span id="numIncomingDisplay"></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Скрытое поле для идентификатора выбранной записи -->
                            <input type="hidden" name="selectedRecordId" id="selectedRecordId" value="">
                            <!-- Поля для редактирования -->
                            <div class="mb-3">
                                <div class="form-group mb-3">
                                    <label for="orgName">Наименование организации:</label>
                                    <input type="text" class="form-control" name="orgName" id="orgName"
                                        value="{{ $item->orgName }}" placeholder="Введите наименование организации"
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="whom">Кому:</label>
                                    <input type="text" class="form-control" name="whom" id="whom"
                                        value="{{ $item->whom }}" placeholder="Введите получателя"required>
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
                                                class="me-3" id="wordFileName">{{ $item->original_file_name }}</a>
                                            {{-- <button type="button" class="btn btn-sm btn-danger"
                                                id="deleteWordFileButton">Удалить файл</button> --}}
                                        @else
                                            Нет файла
                                        @endif
                                        <label for="wordFile" class="btn btn-sm btn-danger ms-3">
                                            Заменить файл
                                            <input type="file" class="form-control" name="word_file" id="wordFile"
                                                style="display: none;">
                                        </label>
                                    </div>
                                </div>

                                <!-- Поле для замены дополнительных файлов -->
                                <span>Дополнительные файлы:</span>
                                <div class="form-group mb-4" id="additionalFiles">
                                    @if ($additionalFiles->count() > 0)
                                        <ul>
                                            @foreach ($additionalFiles as $file)
                                                {{-- <li class="mb-2">
                                                <a href="{{ route('download-kpAdditional', ['id' => $file->id]) }}"
                                                    download class="me-3"
                                                    id="additionalFileName_{{ $file->id }}">{{ $file->original_file_name }}</a>
                                                <label for="additionalFile_{{ $file->id }}"
                                                    class="btn btn-sm btn-danger ms-3">
                                                    Заменить файл
                                                    <input type="file" class="form-control additionalFile"
                                                        name="additionalFile_{{ $file->id }}"
                                                        id="additionalFile_{{ $file->id }}"
                                                        data-file-id="{{ $file->id }}" style="display: none;">
                                                </label>
                                            </li> --}}
                                            @endforeach
                                        </ul>
                                    @endif
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
                            <a class="btn btn-xs btn-danger deleteKPButton" href="#" data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteKP" data-id="{{ $item->id }}">
                                Удалить</a>
                            <input type="hidden" name="delete_offer" id="deleteOffer" value="0">
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="modal fade" id="confirmDeleteKP" tabindex="-1" aria-labelledby="confirmDeleteKPLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteKPLabel">Подтверждение удаления КП
                            {{ $item->numIncoming }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Вы уверены, что хотите удалить это коммерческое предложение?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                pageLength: 20, // Количество записей на странице по умолчанию
                lengthMenu: [20, 40, 60, 100, -1], // Выбор количества записей
                language: {
                    search: 'Поиск:',
                    info: 'Показано с _START_ по _END_ из _TOTAL_ записей',
                    infoEmpty: 'Показано с 0 по 0 из 0 записей',
                    infoFiltered: '(отфильтровано из _MAX_ записей)',
                    lengthMenu: 'Показать _MENU_ записей',
                    sEmptyTable: "НЕТ ЗАПИСЕЙ В ТАБЛИЦЕ",
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


            // Передача данных
            $(document).on('click', '.editKPButton', function() {
                var id = $(this).data('id');
                var kpId = $(this).data('kp-id');
                $('#selectedRecordId').val(id);

                // AJAX запрос для получения данных выбранной записи
                $.ajax({
                    url: '/get-kp-details/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        // Заполнение полей формы данными из ответа
                        $('#numIncomingDisplay').text(response
                            .numIncoming); // Устанавливаем номер проекта
                        $('#orgName').val(response.orgName);
                        $('#whom').val(response.whom);
                        $('#sender').val(response.sender);
                        $('#amountNDS').val(response.amountNDS);
                        $('#purchNum').val(response.purchNum);
                        $('#date').val(response.date);

                        // Вывод файла word_file
                        if (response.wordFile) {
                            $('#wordFileName').text(response.wordFile.name);
                        } else {
                            $('#wordFileName').text('Нет файла');
                        }
                        // Вывод дополнительных файлов
                        var additionalFilesHtml = '';
                        if (response.additionalFiles.length > 0) {
                            $.each(response.additionalFiles, function(index, file) {
                                additionalFilesHtml += '<li class="mb-2">';
                                additionalFilesHtml += '<a href="' + file.url +
                                    '" download id="additionalFileName_' + file.id +
                                    '">' + file.name + '</a>';
                                additionalFilesHtml += '<label for="additionalFile_' +
                                    file.id + '" class="btn btn-sm btn-danger ms-3">';
                                additionalFilesHtml += 'Заменить файл';
                                additionalFilesHtml +=
                                    '<input type="file" class="form-control additionalFile" name="additionalFile_' +
                                    file.id + '" id="additionalFile_' + file.id +
                                    '" data-file-id="' + file.id +
                                    '" style="display: none;">';
                                additionalFilesHtml += '</label>';
                                // Добавляем кнопку удаления файла
                                additionalFilesHtml +=
                                    '<button class="btn btn-sm btn-secondary ms-3 deleteFileButton" data-file-id="' +
                                    file.id + '">Удалить файл</button>';
                                additionalFilesHtml += '</li>';
                            });
                        } else {
                            additionalFilesHtml = 'Нет дополнительных файлов';
                        }
                        $('#additionalFiles').html(additionalFilesHtml);
                    },
                    error: function() {
                        alert('Ошибка при загрузке данных');
                    }
                });
            });


            // Обработчик события изменения файла word
            $(document).on('change', '#wordFile', function() {
                var file = this.files[0];
                var id = $('#selectedRecordId').val();
                var formData = new FormData();
                formData.append('word_file', file);
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
                    url: '/reestr-kp/' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#wordFileName').text(file.name);
                    },
                    error: function() {
                        alert('Ошибка при замене файла');
                    }
                });
            });
            // Обработчик кнопки удаления файла word
            // $(document).on('click', '#deleteWordFileButton', function() {
            //     var id = $('#selectedRecordId').val();
            //     $.ajax({
            //         url: '/reestr-kp/delete-word-file/' + id,
            //         type: 'DELETE',
            //         success: function(response) {
            //             $('#wordFileName').text('Нет файла');
            //         },
            //         error: function() {
            //             alert('Ошибка при удалении файла');
            //         }
            //     });
            // });


            // Обработчик события изменения дополнительного файла
            $(document).on('change', '.additionalFile', function() {
                var file = this.files[0];
                var fileId = $(this).data('file-id'); // Получаем ID файла
                var formData = new FormData();
                formData.append('additional_file', file);
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
                    url: '/reestr-kp/additional-files/' +
                        fileId, // Используем ID файла для замены соответствующего файла
                    type: 'POST', // Используем POST для замены файла
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // В случае успешной замены файла обновляем его имя на странице
                        $('#additionalFileName_' + fileId).text(file.name);
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
                    url: '/delete-kp-additionalfile/' + fileId,
                    type: 'DELETE',
                    success: function(response) {
                        // Скрываем файл на клиентской стороне
                        // $('#additionalFileName_' + fileId).hide();
                        $('#additionalFileName_' + fileId).closest('li')
                            .remove(); // Удаляем соответствующий элемент из DOM
                    },
                    error: function() {
                        alert('Ошибка при удалении файла');
                    }
                });
            });

            // Обработчик события отправки формы
            $('#editKPFormModal').on('submit', function(event) {
                event.preventDefault(); // Предотвращаем отправку формы по умолчанию

                // Создаем объект FormData и добавляем данные формы
                var formData = new FormData(this);

                // Добавляем токен CSRF в данные формы
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                formData.append('_token', csrfToken);

                // Получаем все выбранные дополнительные файлы и добавляем их в FormData
                $('.additionalFile').each(function() {
                    var files = $(this)[0].files;
                    for (var i = 0; i < files.length; i++) {
                        formData.append('additional_files[]', files[i]);
                    }
                });

                // Отправляем ID выбранной записи вместе с данными формы
                var selectedRecordId = $('#selectedRecordId').val();
                formData.append('selectedRecordId', selectedRecordId);

                // Отправляем AJAX запрос
                $.ajax({
                    // url: $(this).attr('action'),
                    url: '/reestr-kp/' + selectedRecordId,
                    type: $(this).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Обработка успешного ответа
                        // console.log(response);
                        window.location.href = '/register-commercial-offers';
                    },
                    error: function(xhr, status, error) {
                        // Обработка ошибок
                        console.error(xhr.responseText);
                    }
                });
            });



            // Удаление кп
            let deleteItemId;
            // Получаем id КП при открытии модального окна
            $('#confirmDeleteKP').on('show.bs.modal', function(event) {
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
                    url: '/delete-kp/' + deleteItemId,
                    success: function(response) {
                        // Обновление страницы или другие действия по желанию
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Вывод сообщения об ошибке или другие действия по желанию
                    }
                });
                $('#confirmDeleteKP').modal('hide');
            });


            // Получаем все ячейки с классом "editable"
            const editableCells = document.querySelectorAll('.editable');
            // Добавляем обработчик событий для каждой ячейки
            editableCells.forEach(cell => {
                cell.addEventListener('blur', function() {
                    const id = this.getAttribute('data-id'); // Получаем идентификатор записи
                    const field = this.getAttribute('data-field'); // Получаем название поля
                    const value = this.innerText.trim(); // Получаем значение из ячейки
                    fetch(`/update-note/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' /
                            },
                            body: JSON.stringify({
                                field: field,
                                value: value
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Ошибка сохранения');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);
                        })
                        .catch(error => {
                            console.error('Ошибка:',error);
                        });
                });
            });

        });
    </script>
@endsection
