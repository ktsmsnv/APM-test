@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-18">
                <h1 class="mb-5">Карта проекта Вн. Номер: {{ $project->projNum }}</h1>

                <ul class="nav nav-mytabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link{{ $tab === 'calculation' ? ' active' : '' }}"id="calculation-tab" data-toggle="tab"
                            href="#calculation" role="tab" aria-controls="calculation" aria-selected="true">Расчет</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="realization-tab" data-toggle="tab" href="#realization" role="tab"
                            aria-controls="realization" aria-selected="false">Реализация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="risks-tab" data-toggle="tab" href="#risks" role="tab"
                            aria-controls="risks" aria-selected="false">Риски</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="changes-tab" data-toggle="tab" href="#changes" role="tab"
                            aria-controls="changes" aria-selected="false">Изменения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="report-tab" data-toggle="tab" href="#report" role="tab"
                            aria-controls="report" aria-selected="false">Отчет</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="smk-tab" data-toggle="tab" href="#smk" role="tab"
                            aria-controls="smk" aria-selected="false">СМК</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab"
                            aria-controls="notes" aria-selected="false">Дневник проекта</a>
                    </li>
                </ul>


                <div class="tab-content mytab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="calculation" role="tabpanel"
                        aria-labelledby="calculation-tab">
                        {{-- @include('tables.calculation-projectMap') --}}
                    </div>
                    <div class="tab-pane fade" id="realization" role="tabpanel" aria-labelledby="realization-tab">
                        {{-- @include('tables.realization-projectMap') --}}
                    </div>
                    <div class="tab-pane fade" id="risks" role="tabpanel" aria-labelledby="risks-tab">
                        {{-- @include('tables.risks-projectMap') --}}
                    </div>
                    <div class="tab-pane fade" id="changes" role="tabpanel" aria-labelledby="changes-tab">
                        {{-- @include('tables.changes-projectMap') --}}
                    </div>
                    <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
                        {{-- @include('tables.report-projectMap') --}}
                    </div>
                    <div class="tab-pane fade" id="smk" role="tabpanel" aria-labelledby="smk-tab">
                        СМК
                    </div>
                    <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                        {{-- @include('tables.notes-projectMap') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ---------------- ОКНО ЗАПОЛНЕНИЯ КАРТЫ ------------------- --}}
    <div class="modal fade" id="addContinueModal" tabindex="-1" aria-labelledby="addContinueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addContinueForm" action="{{ route('project-continue', $project->id) }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContinueModalLabel">Заполнение "Расчет" для карты проекта:
                            {{ $project->projNum }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- ------------- РАНЕЕ ЗАПОЛНЕННЫЕ ДАННЫЕ -------------- --}}
                        <div class="d-flex flex-column">
                            <div class="d-flex gap-3">
                                <p>Номер проекта по реестру:</p>
                                <span>{{ $project->projNum }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Руководитель проекта:</p>
                                <span>{{ $project->projManager }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Головная компания:</p>
                                <span>{{ $project->objectName }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Конечный заказчик:</p>
                                <span>{{ $project->endCustomer }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Контрагент:</p>
                                <span>{{ $project->contractor }}</span>
                            </div>
                            <div class="d-flex gap-3">
                                <p>Дата поступления заявки:</p>
                                <span>{{ $project->date_application }}</span>
                            </div>
                            {{-- <div class="d-flex gap-3">
                            <p>Дата подачи предложения:</p>
                            <span>{{ $project->date_offer }}</span>
                                </div> --}}
                            <h6 class="mt-4 mb-3">Виды работ:</h6>
                            <div class="d-flex gap-5">
                                @if ($project->delivery)
                                    <li>Поставка</li>
                                @endif

                                @if ($project->pir)
                                    <li>ПИР</li>
                                @endif

                                @if ($project->kd)
                                    <li>КД</li>
                                @endif

                                @if ($project->production)
                                    <li>Производство</li>
                                @endif

                                @if ($project->smr)
                                    <li>ШМР</li>
                                @endif

                                @if ($project->pnr)
                                    <li>ПНР</li>
                                @endif

                                @if ($project->po)
                                    <li>ПО</li>
                                @endif

                                @if ($project->cmr)
                                    <li>СМР</li>
                                @endif
                            </div>
                        </div>
                        <div class="mt-2">
                            <h4 class="text-center mb-3">Контакт-лист</h4>
                            <table id="markups-contacts-datatable" class="display nowrap projMap" style="width:100%">
                                <thead>
                                    <tr>
                                        {{-- <th>№</th> --}}
                                        <th>ФИО</th>
                                        <th>Должность</th>
                                        <th>Организация</th>
                                        <th>Зона ответственности</th>
                                        <th>Телефон</th>
                                        <th>Эл.почта</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($project->contacts->count() > 0)
                                        @foreach ($project->contacts as $index => $contact)
                                            <tr>
                                                {{-- <td>{{ $contact->id }}</td> --}}
                                                <td>{{ $contact->fio }}</td>
                                                <td>{{ $contact->post }}</td>
                                                <td>{{ $contact->organization }}</td>
                                                <td>{{ $contact->responsibility }}</td>
                                                <td>{{ $contact->phone }}</td>
                                                <td>{{ $contact->email }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{-- Оборудование --}}
                        <div class="equipment-add alert">
                            <h4 class="mb-3">II Себестоимость оборудования</h4>
                            <div>
                                <div class="mb-3">
                                    <table id="equipment-datatable" class="display nowrap projMap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Наименование ТМЦ</th>
                                                <th>Производитель</th>
                                                <th>Ед. изм.</th>
                                                <th>Кол-во</th>
                                                <th>Цена за ед. (руб. без НДС)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="equipment-inputs">
                                            <tr>
                                                <td><input type="text" class="form-control"
                                                        name="equipment[0][nameTMC]" id="nameTMC"
                                                        placeholder="Введите наименование ТМЦ"></td>
                                                <td> <input type="text" class="form-control"
                                                        name="equipment[0][manufacture]" id="manufacture"
                                                        placeholder="Введите производителя"></td>
                                                <td><input type="text" class="form-control" name="equipment[0][unit]"
                                                        id="unit" placeholder="Введите ед.изм."></td>
                                                <td> <input type="text" class="form-control"
                                                        name="equipment[0][count]" id="count"
                                                        placeholder="Введите количество"></td>
                                                <td><input type="text" class="form-control"
                                                        name="equipment[0][priceUnit]" id="priceUnit"
                                                        placeholder="Введите цену за ед."></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="button" id="addMore-equipment" data-target="equipment"
                                class="btn btn-secondary addMore-button">
                                Добавить еще оборудование
                            </button>

                        </div>
                        {{-- Прочие расходы --}}
                        <div class="expenses-add alert pt-3">
                            <h4 class="mb-3">III Прочие расходы (руб. без НДС)</h4>
                            <div id="expenses-inputs">
                                <div class="form-group mb-3">
                                    <label for="commandir">Командировочные:</label>
                                    <input type="text" class="form-control" name="commandir" id="commandir"
                                        placeholder="Введите командировочные">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="rd">РД:</label>
                                    <input type="text" class="form-control" name="rd" id="rd"
                                        placeholder="Введите РД">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="shmr">ШМР:</label>
                                    <input type="text" class="form-control" name="shmr" id="shmr"
                                        placeholder="Введите ШМР">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pnr">ПНР:</label>
                                    <input type="text" class="form-control" name="pnr" id="pnr"
                                        placeholder="Введите ПНР">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="cert">Сертификаты:</label>
                                    <input type="text" class="form-control" name="cert" id="cert"
                                        placeholder="Введите сертификаты">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="delivery">Доставка/ Логистика:</label>
                                    <input type="text" class="form-control" name="delivery" id="delivery"
                                        placeholder="Введите доставку/логистику">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="rastam">Растаможка:</label>
                                    <input type="text" class="form-control" name="rastam" id="rastam"
                                        placeholder="Введите растаможку">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ppo">Разработка ППО:</label>
                                    <input type="text" class="form-control" name="ppo" id="ppo"
                                        placeholder="Введите разработку ППО">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="guarantee">Банковская гарантия:</label>
                                    <input type="text" class="form-control" name="guarantee" id="guarantee"
                                        placeholder="Введите банковскую гарантию">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="check">Поверка:</label>
                                    <input type="text" class="form-control" name="check" id="check"
                                        placeholder="Введите поверку">
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary addMore-button" id="addMore-expenses"
                                data-target="expenses">
                                Добавить еще дополнительный расход
                            </button>
                        </div>
                        {{-- Итого --}}
                        <div class="total-add alert pt-3">
                            <h4 class="mb-3">IV КСГ</h4>
                            <div class="form-group mb-3">
                                <label for="kdDays">Разработка РКД (дн.):</label>
                                <input type="text" class="form-control" name="kdDays" id="kdDays"
                                    placeholder="Введите кол-во дней">
                            </div>
                            <div class="form-group mb-3">
                                <label for="equipmentDays">Комплектация (дн.):</label>
                                <input type="text" class="form-control" name="equipmentDays" id="equipmentDays"
                                    placeholder="Введите кол-во дней">
                            </div>
                            <div class="form-group mb-3">
                                <label for="productionDays">Производство (дн.):</label>
                                <input type="text" class="form-control" name="productionDays" id="productionDays"
                                    placeholder="Введите кол-во дней">
                            </div>
                            <div class="form-group mb-3">
                                <label for="shipmentDays">Доставка (дн.):</label>
                                <input type="text" class="form-control" name="shipmentDays" id="shipmentDays"
                                    placeholder="Введите кол-во дней">
                            </div>
                        </div>
                        {{-- Уровень наценки --}}
                        <div class="markups-add alert pt-3">
                            <h4 class="mb-3">V Уровень наценки</h4>
                            <div id="markups-inputs">
                                <div class="mb-3">
                                    <div class="form-group mb-3">
                                        <label for="date">Дата:</label>
                                        <input type="date" class="form-control" name="markups[0][date]"
                                            id="date" placeholder="Выберите дату">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="percentage">% наценки:</label>
                                        <input type="text" class="form-control" name="markups[0][percentage]"
                                            id="percentage" placeholder="Введитепроцент наценки">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="priceSubTkp">Сумма подачи ТКП в руб. без НДС:</label>
                                        <input type="text" class="form-control" name="markups[0][priceSubTkp]"
                                            id="priceSubTkp" placeholder="Введите сумму">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="agreedFio">С кем согласовано (Фамилия И.О.):</label>
                                        <input type="text" class="form-control" name="markups[0][agreedFio]"
                                            id="agreedFio" placeholder="Введите ФИО">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Риски --}}
                        <div class="risks-add alert pt-3">
                            <h4 class="text-center">Риски</h4>
                            <div id="risks-inputs">
                                <div class="form-group mb-3">
                                    <label for="riskName">Наименование риска:</label>
                                    <input type="riskName" class="form-control" name="risks[0][riskName]" id="riskName"
                                        placeholder="Введите наименование риска">
                                </div>
                            </div>
                            <button type="button" id="addMore-risks" data-target="risks"
                                class="btn btn-secondary addMore-button">
                                Добавить еще риск
                            </button>
                        </div>
                    </div>
                    {{-- Кнопки --}}
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- ---------------- ОКНО ФОРМИРОВАНИЯ КП ------------------- --}}
    <div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="offerForm" method="post" action="{{ route('reestr-kp.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="offerModalLabel">Формирование коммерческого предложения для {{ $project->projNum }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="project_num" id="projectNum" value="{{ $project->projNum }}">
                        <div class="mb-3">
                            <!-- Другие поля формы -->
                            {{-- <div class="form-group mb-3">
                                <label for="numIncoming">Номер входящего:</label>
                                <input type="text" class="form-control" name="offer[0][numIncoming]" id="numIncoming"
                                    value="{{ $numIncoming }}" readonly>
                            </div> --}}
                            <div class="form-group mb-3">
                                <label for="orgName">Наименование организации:</label>
                                <input type="text" class="form-control" name="offer[0][orgName]" id="orgName"
                                    placeholder="Введите наименование организации" required="">
                            </div>
                            <div class="form-group mb-3">
                                <label for="whom">Кому:</label>
                                <input type="text" class="form-control" name="offer[0][whom]" id="whom"
                                    placeholder="Введите получателя КП">
                            </div>
                            <div class="form-group mb-3">
                                <label for="sender">Отправитель:</label>
                                <input type="text" class="form-control" name="offer[0][sender]" id="sender"
                                    placeholder="Введите отправителя" required="">
                            </div>
                            <div class="form-group mb-3">
                                <label for="amountNDS">Сумма в НДС:</label>
                                <input type="text" class="form-control" name="offer[0][amountNDS]" id="amountNDS"
                                    placeholder="Введите сумму в НДС" required="">
                            </div>
                            <div class="form-group mb-3">
                                <label for="purchNum">№ закупки</label>
                                <input type="text" class="form-control" name="offer[0][purchNum]" id="purchNum"
                                    placeholder="Введите номер закупки">
                            </div>
                            <div class="form-group mb-3">
                                <label for="date">Дата:</label>
                                <input type="text" class="form-control" name="offer[0][date]" id="date"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="wordFile">Файл Word:</label>
                                <input type="file" class="form-control" name="word_file" id="wordFile">
                            </div>
                            <!-- Добавление поля для дополнительных файлов -->
                            <div class="form-group mb-3">
                                <label for="additionalFiles">Дополнительные файлы Word:</label>
                                <input type="file" class="form-control" name="additional_files[]"
                                    id="additionalFiles" multiple>
                            </div>
                        </div>
                    </div>
                    {{-- Кнопки --}}
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Сформировать</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // $('#{{ $tab }}-tab').click();
            $('#{{ $tab }}-tab').tab('show');

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
        });


        $(document).ready(() => {
            let url = location.href.replace(/\/$/, "");

            function loadTabContent(tabId, projectId) {
                console.log(`Fetching content for tab: ${tabId}, project ID: ${projectId}`);
                $.ajax({
                    url: `/tables/${tabId}/${projectId}`, // Use the correct URL with both tabId and projectId
                    type: 'GET',
                    success: function(response) {
                        $(`#${tabId}`).html(response.content);
                        $(`#myTab a[href="#${tabId}"]`).tab("show");

                        const newUrl = `${url.split("#")[0]}#${tabId}`;
                        history.replaceState(null, null, newUrl);
                    },
                    error: function(error) {
                        console.error('Error fetching tab content:', error);
                    }
                });
            }

            const fragment = window.location.hash.substring(1);
            if (fragment) {
                loadTabContent(fragment, '{{ $project->id }}'); // Передаем ID проекта при загрузке страницы
            }

            if (location.hash) {
                const hash = url.split("#");
                loadTabContent(hash[1], '{{ $project->id }}'); // Передаем ID проекта при загрузке страницы
                url = location.href.replace(/\/#/, "#");
                history.replaceState(null, null, url);
                setTimeout(() => {
                    $(window).scrollTop(0);
                }, 400);
            }

            const tabMatch = location.href.match(/#(\w+)$/);
            if (tabMatch) {
                const tabId = tabMatch[1];
                loadTabContent(tabId, '{{ $project->id }}'); // Передаем ID проекта при загрузке страницы
            }

            $('a[data-toggle="tab"]').on("click", function() {
                const tabId = $(this).attr("aria-controls");
                loadTabContent(tabId, '{{ $project->id }}'); // Pass both tabId and projectId
            });
        });
    </script>
@endsection
