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
                            <tr>
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
                                    <a class="btn btn-xs btn-info me-2" href="#" data-bs-toggle="modal"
                                        data-bs-target="#editKP" data-id="{{ $item->id }}"><i
                                            class="fa-solid fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger" href="#"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteKP"
                                        data-id="{{ $item->id }}"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
        });
    </script>
@endsection
