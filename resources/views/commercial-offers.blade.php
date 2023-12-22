@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table id="equipment-datatable" class="display nowrap table" style="width:100%">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>№ исходящего</th>
                            <th>Дата</th>
                            <th>Наименование организации</th>
                            <th>Кому</th>
                            <th>Отправитель</th>
                            <th>Сумма (руб. c НДС)</th>
                            <th>№ закупки</th>
                            <th>Примечания</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($RegReestrKP as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->numIncoming }}</td>
                                <td>{{ date('d.m.Y', strtotime($item->date)) }}</td>
                                <td>{{ $item->orgName }}</td>
                                <td>{{ $item->whom }}</td>
                                <td>{{ $item->sender }}</td>
                                <td>{{ $item->amountNDS }}</td>
                                <td>{{ $item->purchNum }}</td>
                                <td>{{ $item->note }}</td>
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
