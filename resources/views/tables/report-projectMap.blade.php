@if (
	$project->reports()->exists() &&
		$project->reports->first() &&
		$project->basicReference()->exists() &&
		$project->basicReference->first())
	{{-- если отчет существует и реализация существует --}}

	{{-- Отчет --}}
	<div class="report d-flex flex-column pb-5" id="reportTables">
		<h2 class="mb-5">Отчет</h2>
		<table class="reportTable mb-4">
			<tbody>
				<tr>
					<th colspan="3" class="NameTable">Отчет по реализации проекта</th>
				</tr>
				<tr>
					<th class="projName gray">Наименование проекта:</th>
					<td colspan="2" class="gray"><input type="text" class="form-control"
							value="{{ $project->basicReference->first()->projName }}" readonly></td>
				</tr>
				<tr>
					<th class="projContractor gray">Контрагент:</th>
					<td colspan="2" class="gray"><input type="text" class="form-control"
							value="{{ $project->contractor }}" readonly></td>
				</tr>
				<tr>
					<th class="projManager gray">Руководитель проекта:</th>
					<td colspan="2" class="gray"><input type="text" class="form-control"
							value="{{ $project->projManager }}" readonly></td>
				</tr>
				@foreach ($project->reports ?? [] as $item)
					<tr>
						<th class="projProfit blue">Доходная часть</th>
						<td class="blue"></td>
						<td class="blue"></td>
					</tr>
					<tr>
						<td class="blue"></td>
						<th class="rubW blue">Руб (без НДС)</th>
						<th class="rсивub blue">Руб (c НДС)</th>
					</tr>
					<tr>
						<th class="costContract blue">Стоимость по контракту:</th>
						<td class="gray">{{ $project->basicInfo->first()->contract_price }}</td>
						<td class="gray">{{ $project->basicInfo->first()->contract_price * 1.2 }}</td>
					</tr>
					<tr>
						<td class="blue"></td>
						<td class="blue"></td>
						<td class="blue"></td>
					</tr>
					<tr>
						<th class="projExpense  green">Расходная часть</th>
						<td class="green"></td>
						<td class="green"></td>
					</tr>
					<tr>
						<th class="expenseName green">Наименование </th>
						<th class="expensePlan green">Плановое, руб (без НДС)</th>
						<th class="expenseFact green">Фактическое, руб (без НДС)</th>
					</tr>
					<tr>
						<th class="expenseDirect green">Прямые расходы, включая:</th>
						<td>{{ $item->expenseDirectPlan }}</td>
						<td class="gray">{{ $item->expenseDirectFact }}</td>
					</tr>
					<tr>
						<th class="expenseMaterial green">Затраты на материалы (голан):</th>
						<td>{{ $item->expenseMaterialPlan }}</td>
						<td>{{ $item->expenseMaterialFact }}</td>
					</tr>
					<tr>
						<th class="expenseDelivery green">Доставка</th>
						<td>{{ $item->expenseDeliveryPlan }}</td>
						<td>{{ $item->expenseDeliveryFact }}</td>
					</tr>
					<tr>
						<th class="expenseWork green">Затраты на работы:</th>
						<td>{{ $item->expenseWorkPlan }}</td>
						<td>{{ $item->expenseWorkFact }}</td>
					</tr>
					<tr>
						<th class="expenseOther green">Прочие затраты:</th>
						<td>{{ $item->expenseOtherPlan }}</td>
						<td>{{ $item->expenseOtherFact }}</td>
					</tr>
					<tr>
						<th class="expenseOpox green">ОПОХ:</th>
						<td>{{ $item->expenseOpoxPlan }}</td>
						<td>{{ $item->expenseOpoxFact }}</td>
					</tr>
					<tr>
						<th class="marginProfit green">Маржинальная прибыль:</th>
						<td class="gray">{{ $item->marginProfitPlan }}</td>
						<td class="gray">{{ $item->marginProfitFact }}</td>
					</tr>
					<tr>
						<th class="marginality green">Маржинальность проекта, %</th>
						<td>{{ $item->marginalityPlan }}</td>
						<td>{{ $item->marginalityFact }}</td>
					</tr>
					<tr>
						<th class="profit green">Прибыль до вычета налогов:</th>
						<td class="gray">{{ $item->profitPlan }}</td>
						<td class="gray">{{ $item->profitFact }}</td>
					</tr>
					<tr>
						<th class="projProfit green">Рентабельность проекта, %</th>
						<td>{{ $item->projProfitPlan }}</td>
						<td>{{ $item->projProfitFact }}</td>
					</tr>
				@endforeach
				<tr>
					<th class="projNotes green">Примечания к проекту:</th>
					<td colspan="2">
						@if ($project && $project->report_notes->first())
							{{ $project->report_notes->first()->projNotes }}
						@else
							нет записей
						@endif
					</td>
				</tr>
			</tbody>
		</table>
		<div class="d-flex flex-column gap-2">
			<div class="d-flex gap-3">
				<span>Руководитель проекта</span>
				<hr style="width:200px;text-align:left;margin-left:0">
				<input class="gray form-control" type="text" name="proj_manager" id="proj_manager"
					value="{{ $project->projManager }}" readonly style="max-width:200px;">
			</div>
			<div class="d-flex gap-3">
				<span>Главный бухгалтер</span>
				<hr style="width:200px;text-align:left;margin-left:0">
				<input type="text" class="form-control" name="nameTMC" id="nameTMC" value="О.В. Гиндуллина"
					readonly style="max-width:200px;">
			</div>
			<div class="d-flex gap-3">
				<span>Директор по управлению проектами</span>
				<hr style="width:200px;text-align:left;margin-left:0">
				<input type="text" class="form-control" name="nameTMC" id="nameTMC" value="И.А. Игнатьев" readonly
					style="max-width:200px;">
			</div>
			<div class="d-flex gap-3">
				<span>Генеральный директор</span>
				<hr style="width:200px;text-align:left;margin-left:0">
				<input type="text" class="form-control" name="nameTMC" id="nameTMC" value="Н.Е. Артемов" readonly
					style="max-width:200px;">
			</div>
		</div>
	</div>
	{{-- Команда проекта --}}
	<div class="projectTeam d-flex flex-column pb-5" id="reportTables">
		<h2 class="mb-3">Команда проекта</h2>
		<table class="projectTeamTable mb-4">
			<tbody>
				<tr>
					<th colspan="4" class="NameTable">Отчет по реализации проекта</th>
				</tr>
				<tr>
					<th class="projName gray">Наименование проекта:</th>
					<td colspan="3" class="gray"><input type="text" class="form-control"
							value="{{ $project->basicReference->first()->projName }}" readonly></td>
				</tr>
				<tr>
					<th class="projContractor gray">Контрагент:</th>
					<td colspan="3" class="gray"><input type="text" class="form-control"
							value="{{ $project->contractor }}" readonly></td>
				</tr>
				<tr>
					<th class="projManager gray">Руководитель проекта:</th>
					<td colspan="3" class="gray"><input type="text" class="form-control"
							value="{{ $project->projManager }}" readonly></td>
				</tr>
				<tr>
					<th class="premiumPart gray">Размер премиальной части проекта, руб. без НДС</th>
					{{-- <td colspan="3" class="gray"><input type="text" class="form-control" name="premium_part"
							id="premium_part" value="{{ $project->report_team->first()->premium_part }}" readonly></td> --}}
					@if ($project && $project->report_team && $project->report_team->first())
						<td colspan="3" class="gray"><input type="text" class="form-control"
								name="premiumPart" id="premiumPart"
								value="{{ $project->report_team->first()->premium_part }}" readonly>
						</td>
					@else
						<td colspan="3" class="gray"><input type="text" class="form-control"
								name="premiumPart" id="premiumPart" value="" readonly></td>
					@endif
				</tr>
				<tr>
					<th class="projTeam blue">Команда проекта</th>
					<td class="blue"></td>
					<td class="blue"></td>
					<td class="blue"></td>
				</tr>
				<tr>
					<th class="roleFio blue">ФИО (роль в проекте)</th>
					<th class="roleDescription blue">Расширенное описание роли</th>
					<th class="roleImpact blue">Вклад в успех проекта, %</th>
					<th class="roleBonus blue">Дополнительная премия, руб. без НДС</th>
				</tr>
				@foreach ($project->report_team ?? [] as $item)
					<tr>
						<td class="blue">{{ $item->roleFio }}</td>
						<td class="blue">{{ $item->roleDescription }}</td>
						<td>{{ $item->roleImpact }}</td>
						<td class="gray">{{ $item->roleBonus }}</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th class="teamNotes green">Примечания к команде проекта:</th>
					<td colspan="3">
						@if ($project && $project->report_notes->first())
							{{ $project->report_notes->first()->teamNotes }}
						@else
							нет записей
						@endif
					</td>
				</tr>
			</tfoot>
		</table>
		<div class="d-flex flex-column gap-2">
			<div class="d-flex gap-3">
				<span>Руководитель проекта</span>
				<hr style="width:200px;text-align:left;margin-left:0">
				<input type="text" class="form-control gray" name="nameTMC" id="nameTMC"
					value="{{ $project->projManager }}" readonly style="max-width:200px;">
			</div>
			<div class="d-flex gap-3">
				<span>Генеральный директор</span>
				<hr style="width:200px;text-align:left;margin-left:0">
				<input type="text" class="form-control" name="nameTMC" id="nameTMC" value="Н.Е. Артемов"
					readonly style="max-width:200px;">
			</div>
		</div>
	</div>
	{{-- Рефлексия по проекту --}}
	<div class="reflection d-flex flex-column pb-5" id="reportTables">
		<h2 class="mb-3">Рефлексия по проекту</h2>
		<table class="reflectionTable mb-4">
			<tbody>
				<tr>
					<th colspan="3" class="NameTable">Отчет по реализации проекта</th>
				</tr>
				<tr>
					<th class="projName gray">Наименование проекта:</th>
					<td colspan="2" class="gray"><input type="text" class="form-control"
							value="{{ $project->basicReference->first()->projName }}" readonly></td>
				</tr>
				<tr>
					<th class="projContractor gray">Контрагент:</th>
					<td colspan="2" class="gray"><input type="text" class="form-control"
							value="{{ $project->contractor }}" readonly></td>
				</tr>
				<tr>
					<th class="projManager gray">Руководитель проекта:</th>
					<td colspan="2" class="gray"><input type="text" class="form-control"
							value="{{ $project->projManager }}" readonly></td>
				</tr>
				<tr>
					<th class="projReflection blue">Рефлексия по проекту</th>
					<td colspan="2" class="blue"></td>
				</tr>
				<tr>
					<th class="stage blue">Этап</th>
					<th class="advantages blue">Положительные аспекты</th>
					<th class="disadvantages blue">Отрицательные аспекты</th>
				</tr>
				@foreach ($project->report_reflection ?? [] as $item)
					<tr>
						<th class="devRKD blue">Разработка РКД</th>
						<td>{{ $item->devRKD_adv }}</td>
						<td class="blue">{{ $item->devRKD_dis }}</td>
					</tr>
					<tr>
						<th class="complection blue">Комплектация</th>
						<td>{{ $item->complection_adv }}</td>
						<td class="blue">{{ $item->complection_dis }}</td>
					</tr>
					<tr>
						<th class="production blue">Производство</th>
						<td>{{ $item->production_adv }}</td>
						<td class="blue">{{ $item->production_dis }}</td>
					</tr>
					<tr>
						<th class="shipment blue">Отгрузка</th>
						<td>{{ $item->shipment_adv }}</td>
						<td class="blue">{{ $item->shipment_dis }}</td>
					</tr>
				@endforeach
				<tr>
					<th class="resume green">Общее резюме по проекту (что улучшить, точки роста)</th>
					<td colspan="2">
						@if ($project && $project->report_notes->first())
							{{ $project->report_notes->first()->resume }}
						@else
							нет записей
						@endif
					</td>
				</tr>
			</tbody>
		</table>
		<div class="d-flex flex-column gap-2">
			<div class="d-flex gap-3">
				<span>Руководитель проекта</span>
				<hr style="width:200px;text-align:left;margin-left:0">
				<input type="text" class="form-control gray" name="nameTMC" id="nameTMC"
					value="{{ $project->projManager }}" style="max-width:200px;">
			</div>
		</div>
	</div>

	{{-- кнопки --}}
	<div class="d-flex gap-5">
		<a href="{{ route('report-word', [$project->id, $project->projNum]) }}" class="btn btn-primary">Выгрузить в
			WORD</a>
		<div class="d-flex gap-2">
			<button class="btn btn-primary" data-bs-toggle="modal"
				data-bs-target="#reportChange">Редактировать</button>
			{{-- <form action="{{ route('report-delete', $project->id) }}" method="post">
					@csrf
					@method('delete') 
					<button type="submit" class="btn btn-danger">Удалить</button>
				</form> --}}
		</div>
	</div>

	{{-- Модальное окно РЕДАКТИРОВАНИЯ отчета --}}
	<div class="modal fade" id="reportChange" tabindex="-1" aria-labelledby="reportChangeLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<form action="{{ route('report-update-submit', ['id' => $project->id, 'tab' => 'report']) }}"
				method="post">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="reportChangeLabel">Редактирование отчета</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						{{-- Отчет --}}
						<div class="report d-flex flex-column pb-5" id="reportTables">
							<h2 class="mb-5">Отчет | редактирование</h2>
							<table class="reportTable mb-4">
								<tbody>
									<tr>
										<th colspan="3" class="NameTable">Отчет по реализации проекта</th>
									</tr>
									<tr>
										<th class="projName gray">Наименование проекта:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->basicReference->first()->projName }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projContractor gray">Контрагент:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->contractor }}" readonly></td>
									</tr>
									<tr>
										<th class="projManager gray">Руководитель проекта:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->projManager }}" readonly></td>
									</tr>
									@foreach ($project->reports ?? [] as $item)
										<tr>
											<th class="projProfit blue">Доходная часть</th>
											<td class="blue"></td>
											<td class="blue"></td>
										</tr>
										<tr>
											<td class="blue"></td>
											<th class="rubW blue">Руб (без НДС)</th>
											<th class="rсивub blue">Руб (c НДС)</th>
										</tr>
										<tr>
											<th class="costContract blue">Стоимость по контракту:</th>
											<td class="gray"><input type="text" class="form-control"
													name="costRub" id="costRub_change"
													value="{{ $project->basicInfo->first()->contract_price }}">
											</td>
											<td class="gray"><input type="text" class="form-control"
													name="costRubW" id="costRubW_change"
													value="{{ $project->basicInfo->first()->contract_price * 1.2 }}"
													readonly>
											</td>
										</tr>
										<tr>
											<td class="blue"></td>
											<td class="blue"></td>
											<td class="blue"></td>
										</tr>
										<tr>
											<th class="projExpense  green">Расходная часть</th>
											<td class="green"></td>
											<td class="green"></td>
										</tr>
										<tr>
											<th class="expenseName green">Наименование </th>
											<th class="expensePlan green">Плановое, руб (без НДС)</th>
											<th class="expenseFact green">Фактическое, руб (без НДС)</th>
										</tr>
										<tr>
											<th class="expenseDirect green">Прямые расходы, включая:</th>
											<td><input type="text" class="form-control" name="expenseDirectPlan"
													id="expenseDirectPlan_change" placeholder="Введите прямые расходы"
													value="{{ $item->expenseDirectPlan }}"></td>
											<td class="gray"><input type="text" class="form-control"
													name="expenseDirectFact" id="expenseDirectFact_change"
													value="{{ $item->expenseDirectFact }}" readonly></td>
										</tr>
										<tr>
											<th class="expenseMaterial green">Затраты на материалы (голан):</th>
											<td><input type="text" class="form-control" name="expenseMaterialPlan"
													id="expenseMaterialPlan_change"
													placeholder="Введите затраты на материалы (голан)"
													value="{{ $item->expenseMaterialPlan }}">
											</td>
											<td><input type="text" class="form-control" name="expenseMaterialFact"
													id="expenseMaterialFact_change"
													placeholder="Введите затраты на материалы (голан)"
													value="{{ $item->expenseMaterialFact }}">
											</td>
										</tr>
										<tr>
											<th class="expenseDelivery green">Доставка</th>
											<td><input type="text" class="form-control" name="expenseDeliveryPlan"
													id="expenseDeliveryPlan_change"
													placeholder="Введите расходы на доставку"
													value="{{ $item->expenseDeliveryPlan }}">
											</td>
											<td><input type="text" class="form-control" name="expenseDeliveryFact"
													id="expenseDeliveryFact_change"
													placeholder="Введите расходы на доставку"
													value="{{ $item->expenseDeliveryFact }}">
											</td>
										</tr>
										<tr>
											<th class="expenseWork green">Затраты на работы:</th>
											<td><input type="text" class="form-control" name="expenseWorkPlan"
													id="expenseWorkPlan_change"
													placeholder="Введите затраты на работы"
													value="{{ $item->expenseWorkPlan }}"></td>
											<td><input type="text" class="form-control" name="expenseWorkFact"
													id="expenseWorkFact_change"
													placeholder="Введите затраты на работы"
													value="{{ $item->expenseWorkFact }}"></td>
										</tr>
										<tr>
											<th class="expenseOther green">Прочие затраты:</th>
											<td><input type="text" class="form-control" name="expenseOtherPlan"
													id="expenseOtherPlan_change" placeholder="Введите прочие затраты"
													value="{{ $item->expenseOtherPlan }}"></td>
											<td><input type="text" class="form-control" name="expenseOtherFact"
													id="expenseOtherFact_change" placeholder="Введите прочие затраты"
													value="{{ $item->expenseOtherFact }}"></td>
										</tr>
										<tr>
											<th class="expenseOpox green">ОПОХ:</th>
											<td><input type="text" class="form-control" name="expenseOpoxPlan"
													id="expenseOpoxPlan_change" placeholder="Введите ОПОХ"
													value="{{ $item->expenseOpoxPlan }}"></td>
											<td><input type="text" class="form-control" name="expenseOpoxFact"
													id="expenseOpoxFact_change" placeholder="Введите ОПОХ"
													value="{{ $item->expenseOpoxFact }}"></td>
										</tr>
										<tr>
											<th class="marginProfit green">Маржинальная прибыль:</th>
											<td class="gray"><input type="text" class="form-control"
													name="marginProfitPlan" id="marginProfitPlan_change"
													value="{{ $project->basicInfo->first()->profit_plan }}" readonly>
											</td>
											<td class="gray"><input type="text" class="form-control"
													name="marginProfitFact" id="marginProfitFact_change"
													value="{{ $item->marginProfitFact }}" readonly></td>
										</tr>
										<tr>
											<th class="marginality green">Маржинальность проекта, %</th>
											<td><input type="text" class="form-control" name="marginalityPlan"
													id="marginalityPlan_change"
													value="{{ ceil($project->basicInfo->first()->profit_plan / $project->basicInfo->first()->contract_price) }}"
													readonly></td>
											<td><input type="text" class="form-control" name="marginalityFact"
													id="marginalityFact_change" value="{{ $item->marginalityFact }}"
													readonly>
											</td>
										</tr>
										<tr>
											<th class="profit green">Прибыль до вычета налогов:</th>
											<td class="gray"><input type="text" class="form-control"
													name="profitPlan" id="profitPlan_change"
													value="{{ $item->profitPlan }}" readonly>
											</td>
											<td class="gray"><input type="text" class="form-control"
													name="profitFact" id="profitFact_change"
													value="{{ $item->profitFact }}" readonly>
											</td>
										</tr>
										<tr>
											<th class="projProfit green">Рентабельность проекта, %</th>
											<td><input type="text" class="form-control" name="projProfitPlan"
													id="projProfitPlan_change" value="{{ $item->projProfitPlan }}">
											</td>
											<td><input type="text" class="form-control" name="projProfitFact"
													id="projProfitFact_change" value="{{ $item->projProfitFact }}">
											</td>
										</tr>
									@endforeach
									<tr>
										<th class="projNotes green">Примечания к проекту:</th>
										<td colspan="2">
											<textarea type="text" class="form-control" name="projNotes" id="projNotes_change"
												placeholder="Введите примечания к проекту">
												@if ($project && $project->report_notes->first())
                                                {{ $project->report_notes->first()->projNotes }}
                                                @else
                                                нет записей
                                                @endif
											</textarea>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="d-flex flex-column gap-2">
								<div class="d-flex gap-3">
									<span>Руководитель проекта</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input class="gray form-control" type="text" name="proj_manager"
										id="proj_manager" value="{{ $project->projManager }}" readonly
										style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Главный бухгалтер</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="О.В. Гиндуллина" readonly style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Директор по управлению проектами</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="И.А. Игнатьев" readonly style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Генеральный директор</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="Н.Е. Артемов" readonly style="max-width:200px;">
								</div>
							</div>
						</div>
						{{-- Команда проекта --}}
						<div class="projectTeam d-flex flex-column pb-5" id="reportTables">
							<h2 class="mb-3">Команда проекта | редактирование</h2>
							<table class="projectTeamTable mb-4">
								<tbody id="reportTeamChange-inputs">
									<tr>
										<th colspan="4" class="NameTable">Отчет по реализации проекта</th>
									</tr>
									<tr>
										<th class="projName gray">Наименование проекта:</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												value="{{ $project->basicReference->first()->projName }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projContractor gray">Контрагент:</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												value="{{ $project->contractor }}" readonly></td>
									</tr>
									<tr>
										<th class="projManager gray">Руководитель проекта:</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												value="{{ $project->projManager }}" readonly></td>
									</tr>
									<tr>
										<th class="premiumPart gray">Размер премиальной части проекта, руб. без НДС
										</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												name="roles[0][premiumPart]" id="premium_part_change"
												value="{{ $project->report_team->first()->premium_part }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projTeam blue">Команда проекта</th>
										<td class="blue"></td>
										<td class="blue"></td>
										<td class="blue"></td>
									</tr>
									<tr>
										<th class="roleFio blue">ФИО (роль в проекте)</th>
										<th class="roleDescription blue">Расширенное описание роли</th>
										<th class="roleImpact blue">Вклад в успех проекта, %</th>
										<th class="roleBonus blue">Дополнительная премия, руб. без НДС</th>
									</tr>
									@foreach ($project->report_team ?? [] as $index => $item)
										<tr>
											<input type="hidden" name="roles[{{ $index }}][roleId]"
												value="{{ $item->id }}">
											<td class="blue"><input type="text" class="form-control"
													name="roles[{{ $index }}][roleFio]" id="roleFio_change"
													placeholder="Введите ФИО (роль в проекте)"
													value="{{ $item->roleFio }}"></td>
											<td class="blue"><input type="text" class="form-control"
													name="roles[{{ $index }}][roleDescription]"
													id="roleDescription_change"
													placeholder="Введите расширенное описание роли"
													value="{{ $item->roleDescription }}">
											</td>
											<td><input type="text" class="form-control"
													name="roles[{{ $index }}][roleImpact]"
													id="roleImpact_change"
													placeholder="Введите вклад в успех проекта, %"
													value="{{ $item->roleImpact }}"></td>
											<td class="gray"><input type="text" class="form-control"
													name="roles[{{ $index }}][roleBonus]"
													id="roleBonus_change"
													placeholder="Введите дополнительную премию, руб. без НДС"
													value="{{ $item->roleBonus }}"></td>
											<td class="gray"><input type="hidden" class="form-control" name="roles[{{ $index }}][premium_part]"
												id="premium_part_change" placeholder="Введите дополнительную премию, руб. без НДС"
												value="{{ $item->premium_part }}"></td>
											<td>
												<button class="btn btn-danger btn-sm deleteTeam_Btn"
													data-id="{{ $item->id }}">Удалить</button>
											</td>

										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4"><button id="addMoreChange-reportTeam"
												class="btn btn-secondary w-100" type="button">Добавить роль</button>
										</td>
									</tr>
									<tr>
										<th class="teamNotes green">Примечания к команде проекта:</th>
										<td colspan="3">
											<textarea type="text" class="form-control" name="teamNotes" id="teamNotes_change"
												placeholder="Введите примечания к команде проекта">
												@if ($project && $project->report_notes->first())
														{{ $project->report_notes->first()->teamNotes }}
														@else
														нет записей
														@endif
											</textarea>
										</td>
									</tr>
								</tfoot>
							</table>
							<div class="d-flex flex-column gap-2">
								<div class="d-flex gap-3">
									<span>Руководитель проекта</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control gray" name="nameTMC" id="nameTMC"
										value="{{ $project->projManager }}" readonly style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Генеральный директор</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="Н.Е. Артемов" readonly style="max-width:200px;">
								</div>
							</div>
						</div>
						{{-- Рефлексия по проекту --}}
						<div class="reflection d-flex flex-column pb-5" id="reportTables">
							<h2 class="mb-3">Рефлексия по проекту | редактирование</h2>
							<table class="reflectionTable mb-4">
								<tbody>
									<tr>
										<th colspan="3" class="NameTable">Отчет по реализации проекта</th>
									</tr>
									<tr>
										<th class="projName gray">Наименование проекта:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->basicReference->first()->projName }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projContractor gray">Контрагент:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->contractor }}" readonly></td>
									</tr>
									<tr>
										<th class="projManager gray">Руководитель проекта:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->projManager }}" readonly></td>
									</tr>
									<tr>
										<th class="projReflection blue">Рефлексия по проекту</th>
										<td colspan="2" class="blue"></td>
									</tr>
									<tr>
										<th class="stage blue">Этап</th>
										<th class="advantages blue">Положительные аспекты</th>
										<th class="disadvantages blue">Отрицательные аспекты</th>
									</tr>
									@foreach ($project->report_reflection ?? [] as $item)
										<tr>
											<th class="devRKD blue">Разработка РКД</th>
											<td><input type="text" class="form-control" name="devRKD_adv"
													id="devRKD_adv" placeholder="Введите разработку РКД"
													value="{{ $item->devRKD_adv }}"></td>
											<td class="blue"><input type="text" class="form-control"
													name="devRKD_dis" id="devRKD_dis"
													placeholder="Введите разработку РКД"
													value="{{ $item->devRKD_dis }}">
											</td>
										</tr>
										<tr>
											<th class="complection blue">Комплектация</th>
											<td><input type="text" class="form-control" name="complection_adv"
													id="complection_adv" placeholder="Введите комплектацию"
													value="{{ $item->complection_adv }}"></td>
											<td class="blue"><input type="text" class="form-control"
													name="complection_dis" id="complection_dis"
													placeholder="Введите комплектацию"
													value="{{ $item->complection_dis }}">
											</td>
										</tr>
										<tr>
											<th class="production blue">Производство</th>
											<td><input type="text" class="form-control" name="production_adv"
													id="production_adv" placeholder="Введите производство"
													value="{{ $item->production_adv }}"></td>
											<td class="blue"><input type="text" class="form-control"
													name="production_dis" id="production_dis"
													placeholder="Введите производство"
													value="{{ $item->production_dis }}">
											</td>
										</tr>
										<tr>
											<th class="shipment blue">Отгрузка</th>
											<td><input type="text" class="form-control" name="shipment_adv"
													id="shipment_adv" placeholder="Введите отгрузку"
													value="{{ $item->shipment_adv }}"></td>
											<td class="blue"><input type="text" class="form-control"
													name="shipment_dis" id="shipment_dis"
													placeholder="Введите отгрузку"
													value="{{ $item->shipment_dis }}">
											</td>
										</tr>
									@endforeach
									<tr>
										<th class="resume green">Общее резюме по проекту (что улучшить, точки роста)
										</th>
										<td colspan="2">
											<textarea type="text" class="form-control" name="resume" id="resume" placeholder=""Введите общее резюме по
												проекту">
												@if ($project && $project->report_notes->first())
											{{ $project->report_notes->first()->resume }}
											@else
											нет записей
											@endif
											   </textarea>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="d-flex flex-column gap-2">
								<div class="d-flex gap-3">
									<span>Руководитель проекта</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control gray" name="nameTMC" id="nameTMC"
										value="{{ $project->projManager }}" style="max-width:200px;">
								</div>
							</div>
						</div>
					</div>
					{{-- Кнопки --}}
					<div class="modal-footer d-flex justify-content-between">
						<button type="submit" class="btn btn-success mt-3">Сохранить</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	{{-- Доп. строки для реадктирования --}}
	<script>
		$(document).ready(function() {
			let index = 0;
			$("#addMoreChange-reportTeam").click(function(event) {
				event.preventDefault();
				index++;

				const sum = Math.round(parseFloat($('#expenseMaterialFact_change').val() || 0) +
					parseFloat($('#expenseDeliveryFact_change').val() || 0) +
					parseFloat($('#expenseWorkFact_change').val() || 0) +
					parseFloat($('#expenseOtherFact_change').val() || 0) +
					parseFloat($('#expenseOpoxFact_change').val() || 0));
				const difference = Math.round(parseFloat($('#costRubW_change').val() || 0) - sum);
				const premium_part = Math.round(difference * 0.01);


				const newRow = $(getHtml_change(index, premium_part));
				newRow.appendTo(`#reportTeamChange-inputs`);

				newRow.find('.deleteChange-btn').on('click', function() {
				newRow.remove();
			})
			});
		});
        function getHtml_change(index, premium_part) {
            // let roleId = ''; // Создаем пустую строку для roleId
            // // Генерируем уникальный roleId для новой строки
            // if (index >= {{ count($project->report_team ?? []) }}) {
            //     roleId = 'new' + (index + 1);
            // }
            return `
                <tr>
                    <input type="hidden" name="roles[${index}][roleId]" value="">
                    <th class="premiumPart gray d-none">размер премиальной части проекта, руб. без НДС</th>
                    <td colspan="3" class="gray d-none"><input type="text" class="form-control"
                        name="roles[${index}][premium_part]" id="premium_part_change_${index}" value="${premium_part}"></td>
                </tr>
                <tr>
                    <td class="blue"><input type="text" class="form-control" name="roles[${index}][roleFio]"
                        id="roleFio_change_${index}" placeholder="Введите ФИО (роль в проекте)"></td>
                    <td class="blue"><input type="text" class="form-control" name="roles[${index}][roleDescription]"
                        id="roleDescription_change_${index}" placeholder="Введите расширенное описание роли"></td>
                    <td><input type="text" class="form-control" name="roles[${index}][roleImpact]"
                        id="roleImpact_change_${index}" placeholder="Введите вклад в успех проекта, %"></td>
                    <td class="gray"><input type="text" class="form-control" name="roles[${index}][roleBonus]"
                        id="roleBonus_change_${index}" placeholder="Введите дополнительную премию, руб. без НДС"></td>
                    <td><button type="button" class="btn btn-danger btn-sm deleteChange-btn"><i class="fas fa-times"></i></button></td></td>
                </tr>
            `
        }

        // ---------- удаление строк из команды проекта -----------------
		$(document).ready(function() {
			$('.deleteTeam_Btn').click(function() {
				event.preventDefault();
				var rowId = $(this).data('id');
				var rowToDelete = $(this).closest('tr'); 

				$.ajax({
					url: "{{ route('deleteRow', ['id' => '__id__']) }}".replace('__id__', rowId),
					method: "DELETE",
					headers: {
								'X-CSRF-TOKEN': '{{ csrf_token() }}' 
							},
					data: {
						id: rowId
					},
					success: function(response) {
						console.log(response);
						rowToDelete.remove();
					},
					error: function(xhr, status, error) {
						console.error(xhr.responseText);
					}
				});
			});
		});
        // 	{{-- Расчет полей для редактирования --}}
		function calculateAndUpdateFields() {
			const sum_change = Math.round(parseFloat($('#expenseMaterialFact_change').val() || 0) +
				parseFloat($('#expenseDeliveryFact_change').val() || 0) +
				parseFloat($('#expenseWorkFact_change').val() || 0) +
				parseFloat($('#expenseOtherFact_change').val() || 0) +
				parseFloat($('#expenseOpoxFact_change').val() || 0));

			const difference_change = Math.round(parseFloat($('#costRubW_change').val() || 0) - sum_change);

			const marginalityFact_change = Math.round(parseFloat($('#marginProfitFact_change').val() || 0) /
				parseFloat($('#costRubW_change').val() || 0));

			const profitPlan_change = (parseFloat($('#marginProfitPlan_change').val() || 0) - parseFloat($(
				'#expenseOpoxPlan_change').val() || 0));

			const profitFact_change = difference_change - parseFloat($('#expenseOpoxFact_change').val() || 0);

			const projProfitPlan_change = Math.round(parseFloat($('#profitPlan_change').val() || 0) / parseFloat($(
				'#costRubW_change').val() || 0));

			const projProfitFact_change = Math.round(parseFloat($('#profitFact_change').val() || 0) / parseFloat($(
				'#costRubW_change').val() || 0));

			const premium_part_change = Math.round(difference_change * 0.01);

			// Обновляем поля
			$('#expenseDirectFact_change').val(sum_change);
			$('#marginProfitFact_change').val(difference_change);
			$('#marginalityFact_change').val(marginalityFact_change);
			$('#profitPlan_change').val(profitPlan_change);
			$('#profitFact_change').val(profitFact_change);
			$('#projProfitPlan_change').val(projProfitPlan_change);
			$('#projProfitFact_change').val(projProfitFact_change);

			$('#premium_part_change').val(premium_part_change);
		}
		$(document).ready(function() {
			// Указываем, что при изменении текстовых полей нужно вызывать функцию:
			$("#expenseMaterialFact_change, #expenseDeliveryFact_change, #expenseWorkFact_change, #expenseOtherFact_change, #expenseOpoxFact_change, #costRubW_change, #expenseDirectFact_change, #marginProfitFact_change, #marginalityPlan_change, #expenseOpoxPlan_change, #expenseOpoxFact_change, #profitPlan_change, #profitFact_change, #premium_part_change")
				.on('input', calculateAndUpdateFields);
		});
	</script>


{{-- ---------------------------------- ОТСУТСВИЕ РАСЧЕТА ЧАСТИЧНО -------------------------------------------- --}}
@elseif($project && $project->totals && $project->totals->isEmpty())
	<p>Для добавления отчета необходимо заполнить "Расчет" полностью.</p>
	<a href="#" data-bs-toggle="modal" data-bs-target="#addContinueModal" class="btn btn-danger mb-4">
		Продолжить заполнение расчета
	</a>
{{-- -------------------------------- ОТСУТСВИЕ РАСЧЕТА И РЕАЛИЗАЦИИ ------------------------------------------ --}}
@elseif (!$project->reports()->exists() && !$project->basicReference()->exists())
	{{-- если отчета и реализации нет --}}
	<h4 class="mb-3">Заполните сначала реализацию</h4>
	<a href="{{ route('realization-create', $project->id) }}"><button class="btn btn-danger">Заполнить
			реализацию</button></a>

{{-- ------------------------------------- ОТСУТСТВИЕ ОТЧЕТА ---------------------------------------- --}}
@else
	{{-- если только отчета нет --}}
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
		Сформировать отчет
	</button>
	{{-- Модальное окно формирование отчета --}}
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<form action="{{ route('report-store', $project->id) }}" method="post">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Формирование отчета</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						{{-- Отчет --}}
						<div class="report d-flex flex-column pb-5" id="reportTables">
							<h2 class="mb-5">Отчет</h2>
							<table class="reportTable mb-4">
								<tbody>
									<tr>
										<th colspan="3" class="NameTable">Отчет по реализации проекта</th>
									</tr>
									<tr>
										<th class="projName gray">Наименование проекта:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->basicReference->first()->projName }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projContractor gray">Контрагент:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->contractor }}" readonly></td>
									</tr>
									<tr>
										<th class="projManager gray">Руководитель проекта:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->projManager }}" readonly></td>
									</tr>
									<tr>
										<th class="projProfit blue">Доходная часть</th>
										<td class="blue"></td>
										<td class="blue"></td>
									</tr>
									<tr>
										<td class="blue"></td>
										<th class="costRubW blue">Руб (без НДС)</th>
										<th class="costRub blue">Руб (c НДС)</th>
									</tr>
									<tr>
										<th class="costContract blue">Стоимость по контракту:</th>
										<td class="gray"><input type="text" class="form-control"
												name="costRubW" id="costRubW"
												value="{{ $project->basicInfo->first()->contract_price }}" readonly>
										</td>
										<td class="gray"><input type="text" class="form-control" name="costRub"
												id="costRub"
												value="{{ $project->basicInfo->first()->contract_price * 1.2 }}"
												readonly>
										</td>
									</tr>
									<tr>
										<td class="blue"></td>
										<td class="blue"></td>
										<td class="blue"></td>
									</tr>
									<tr>
										<th class="projExpense  green">Расходная часть</th>
										<td class="green"></td>
										<td class="green"></td>
									</tr>
									<tr>
										<th class="expenseName green">Наименование </th>
										<th class="expensePlan green">Плановое, руб (без НДС)</th>
										<th class="expenseFact green">Фактическое, руб (без НДС)</th>
									</tr>
									<tr>
										<th class="expenseDirect green">Прямые расходы, включая:</th>
										<td><input type="text" class="form-control" name="expenseDirectPlan"
												id="expenseDirectPlan" placeholder="Введите прямые расходы"></td>
										<td class="gray"><input type="text" class="form-control"
												name="expenseDirectFact" id="expenseDirectFact" readonly></td>
									</tr>
									<tr>
										<th class="expenseMaterial green">Затраты на материалы (голан):</th>
										<td><input type="text" class="form-control" name="expenseMaterialPlan"
												id="expenseMaterialPlan"
												placeholder="Введите затраты на материалы (голан)">
										</td>
										<td><input type="text" class="form-control" name="expenseMaterialFact"
												id="expenseMaterialFact"
												placeholder="Введите затраты на материалы (голан)">
										</td>
									</tr>
									<tr>
										<th class="expenseDelivery green">Доставка</th>
										<td><input type="text" class="form-control" name="expenseDeliveryPlan"
												id="expenseDeliveryPlan" placeholder="Введите расходы на доставку">
										</td>
										<td><input type="text" class="form-control" name="expenseDeliveryFact"
												id="expenseDeliveryFact" placeholder="Введите расходы на доставку">
										</td>
									</tr>
									<tr>
										<th class="expenseWork green">Затраты на работы:</th>
										<td><input type="text" class="form-control" name="expenseWorkPlan"
												id="expenseWorkPlan" placeholder="Введите затраты на работы"></td>
										<td><input type="text" class="form-control" name="expenseWorkFact"
												id="expenseWorkFact" placeholder="Введите затраты на работы"></td>
									</tr>
									<tr>
										<th class="expenseOther green">Прочие затраты:</th>
										<td><input type="text" class="form-control" name="expenseOtherPlan"
												id="expenseOtherPlan" placeholder="Введите прочие затраты"></td>
										<td><input type="text" class="form-control" name="expenseOtherFact"
												id="expenseOtherFact" placeholder="Введите прочие затраты"></td>
									</tr>
									<tr>
										<th class="expenseOpox green">ОПОХ:</th>
										<td><input type="text" class="form-control" name="expenseOpoxPlan"
												id="expenseOpoxPlan" placeholder="Введите ОПОХ"></td>
										<td><input type="text" class="form-control" name="expenseOpoxFact"
												id="expenseOpoxFact" placeholder="Введите ОПОХ"></td>
									</tr>
									<tr>
										<th class="marginProfit green">Маржинальная прибыль:</th>
										<td class="gray"><input type="text" class="form-control"
												name="marginProfitPlan" id="marginProfitPlan"
												value="{{ $project->basicInfo->first()->profit_plan }}" readonly>
										</td>
										<td class="gray"><input type="text" class="form-control"
												name="marginProfitFact" id="marginProfitFact" readonly></td>
									</tr>
									<tr>
										<th class="marginality green">Маржинальность проекта, %</th>
										<td><input type="text" class="form-control" name="marginalityPlan"
												id="marginalityPlan"
												value="{{ ceil($project->basicInfo->first()->profit_plan / $project->basicInfo->first()->contract_price) }}"
												readonly></td>
										<td><input type="text" class="form-control" name="marginalityFact"
												id="marginalityFact" readonly></td>
									</tr>
									<tr>
										<th class="profit green">Прибыль до вычета налогов:</th>
										<td class="gray"><input type="text" class="form-control"
												name="profitPlan" id="profitPlan" readonly></td>
										<td class="gray"><input type="text" class="form-control"
												name="profitFact" id="profitFact" readonly></td>
									</tr>
									<tr>
										<th class="projProfit green">Рентабельность проекта, %</th>
										<td><input type="text" class="form-control" name="projProfitPlan"
												id="projProfitPlan" readonly></td>
										<td><input type="text" class="form-control" name="projProfitFact"
												id="projProfitFact" readonly></td>
									</tr>
									<tr>
										<th class="projNotes green">Примечания к проекту:</th>
										<td colspan="2">
											<textarea type="text" class="form-control" name="projNotes" id="projNotes"
												placeholder="Введите примечания к проекту"></textarea>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="d-flex flex-column gap-2">
								<div class="d-flex gap-3">
									<span>Руководитель проекта</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input class="gray form-control" type="text" name="proj_manager"
										id="proj_manager" value="{{ $project->projManager }}" readonly
										style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Главный бухгалтер</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="О.В. Гиндуллина" readonly style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Директор по управлению проектами</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="И.А. Игнатьев" readonly style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Генеральный директор</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="Н.Е. Артемов" readonly style="max-width:200px;">
								</div>
							</div>
						</div>
						{{-- Команда проекта --}}
						<div class="projectTeam d-flex flex-column pb-5" id="reportTables">
							<h2 class="mb-3">Команда проекта</h2>
							<table class="projectTeamTable mb-4">
								<tbody id="reportTeam-inputs">
									<tr>
										<th colspan="4" class="NameTable">Отчет по реализации проекта</th>
									</tr>
									<tr>
										<th class="projName gray">Наименование проекта:</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												value="{{ $project->basicReference->first()->projName }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projContractor gray">Контрагент:</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												value="{{ $project->contractor }}" readonly></td>
									</tr>
									<tr>
										<th class="projManager gray">Руководитель проекта:</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												value="{{ $project->projManager }}" readonly></td>
									</tr>
									<tr>
										<th class="premiumPart gray">Размер премиальной части проекта, руб. без НДС
										</th>
										<td colspan="3" class="gray"><input type="text" class="form-control"
												name="roles[0][premium_part]" id="premium_part" readonly></td>
									</tr>
									<tr>
										<th class="projTeam blue">Команда проекта</th>
										<td class="blue"></td>
										<td class="blue"></td>
										<td class="blue"></td>
									</tr>
									<tr>
										<th class="roleFio blue">ФИО (роль в проекте)</th>
										<th class="roleDescription blue">Расширенное описание роли</th>
										<th class="roleImpact blue">Вклад в успех проекта, %</th>
										<th class="roleBonus blue">Дополнительная премия, руб. без НДС</th>
									</tr>
									<tr>
										<td class="blue"><input type="text" class="form-control"
												name="roles[0][roleFio]" id="roleFio"
												placeholder="Введите ФИО (роль в проекте)"></td>
										<td class="blue"><input type="text" class="form-control"
												name="roles[0][roleDescription]" id="roleDescription"
												placeholder="Введите расширенное описание роли"
												value="Ведение проекта">
										</td>
										<td><input type="text" class="form-control" name="roles[0][roleImpact]"
												id="roleImpact" placeholder="Введите вклад в успех проекта, %"
												value="100%"></td>
										<td class="gray"><input type="text" class="form-control"
												name="roles[0][roleBonus]" id="roleBonus"
												placeholder="Введите дополнительную премию, руб. без НДС"></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4">
											<button id="addMore-reportTeam" class="btn btn-secondary w-100"
												type="button">Добавить роль</button>
										</td>
									</tr>
									<tr>
										<th class="teamNotes green">Примечания к команде проекта:</th>
										<td colspan="3">
											<textarea type="text" class="form-control" name="teamNotes" id="teamNotes"
												placeholder="Введите примечания к команде проекта"></textarea>
										</td>
									</tr>
								</tfoot>
							</table>
							<div class="d-flex flex-column gap-2">
								<div class="d-flex gap-3">
									<span>Руководитель проекта</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control gray" name="nameTMC" id="nameTMC"
										value="{{ $project->projManager }}" readonly style="max-width:200px;">
								</div>
								<div class="d-flex gap-3">
									<span>Генеральный директор</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control" name="nameTMC" id="nameTMC"
										value="Н.Е. Артемов" readonly style="max-width:200px;">
								</div>
							</div>
						</div>
						{{-- Рефлексия по проекту --}}
						<div class="reflection d-flex flex-column pb-5" id="reportTables">
							<h2 class="mb-3">Рефлексия по проекту</h2>
							<table class="reflectionTable mb-4">
								<tbody>
									<tr>
										<th colspan="3" class="NameTable">Отчет по реализации проекта</th>
									</tr>
									<tr>
										<th class="projName gray">Наименование проекта:</th>
										<td colspan="2" class="gray"><input type="text" class="form-control"
												value="{{ $project->basicReference->first()->projName }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projContractor gray">Контрагент:</th>
										<td colspan="2" class="gray"><input type="text"
												class="form-control" value="{{ $project->contractor }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projManager gray">Руководитель проекта:</th>
										<td colspan="2" class="gray"><input type="text"
												class="form-control" value="{{ $project->projManager }}" readonly>
										</td>
									</tr>
									<tr>
										<th class="projReflection blue">Рефлексия по проекту</th>
										<td colspan="2" class="blue"></td>
									</tr>
									<tr>
										<th class="stage blue">Этап</th>
										<th class="advantages blue">Положительные аспекты</th>
										<th class="disadvantages blue">Отрицательные аспекты</th>
									</tr>
									<tr>
										<th class="devRKD blue">Разработка РКД</th>
										<td><input type="text" class="form-control" name="devRKD_adv"
												id="devRKD_adv" placeholder="Введите разработку РКД"></td>
										<td class="blue"><input type="text" class="form-control"
												name="devRKD_dis" id="devRKD_dis"
												placeholder="Введите разработку РКД">
										</td>
									</tr>
									<tr>
										<th class="complection blue">Комплектация</th>
										<td><input type="text" class="form-control" name="complection_adv"
												id="complection_adv" placeholder="Введите комплектацию"></td>
										<td class="blue"><input type="text" class="form-control"
												name="complection_dis" id="complection_dis"
												placeholder="Введите комплектацию">
										</td>
									</tr>
									<tr>
										<th class="production blue">Производство</th>
										<td><input type="text" class="form-control" name="production_adv"
												id="production_adv" placeholder="Введите производство"></td>
										<td class="blue"><input type="text" class="form-control"
												name="production_dis" id="production_dis"
												placeholder="Введите производство">
										</td>
									</tr>
									<tr>
										<th class="shipment blue">Отгрузка</th>
										<td><input type="text" class="form-control" name="shipment_adv"
												id="shipment_adv" placeholder="Введите отгрузку"></td>
										<td class="blue"><input type="text" class="form-control"
												name="shipment_dis" id="shipment_dis"
												placeholder="Введите отгрузку">
										</td>
									</tr>
									<tr>
										<th class="resume green">Общее резюме по проекту (что улучшить, точки роста)
										</th>
										<td colspan="2">
											<textarea type="text" class="form-control" name="resume" id="resume"
												placeholder="Введите общее резюме по проекту"></textarea>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="d-flex flex-column gap-2">
								<div class="d-flex gap-3">
									<span>Руководитель проекта</span>
									<hr style="width:200px;text-align:left;margin-left:0">
									<input type="text" class="form-control gray" name="nameTMC"
										id="nameTMC" value="{{ $project->projManager }}"
										style="max-width:200px;">
								</div>
							</div>
						</div>
					</div>
					{{-- Кнопки --}}
					<div class="modal-footer d-flex justify-content-between">
						<button type="submit" class="btn btn-success mt-3">Сохранить</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endif





{{-- Доп. строки --}}
<script>
	$(document).ready(function() {
		let index = 0;
		$("#addMore-reportTeam").click(function(event) {
			event.preventDefault();
			index++;

			const sum = Math.round(parseFloat($('#expenseMaterialFact').val() || 0) +
				parseFloat($('#expenseDeliveryFact').val() || 0) +
				parseFloat($('#expenseWorkFact').val() || 0) +
				parseFloat($('#expenseOtherFact').val() || 0) +
				parseFloat($('#expenseOpoxFact').val() || 0));
			const difference = Math.round(parseFloat($('#costRubW').val() || 0) - sum);
			const premium_part = Math.round(difference * 0.01);


			const newRow = $(getHtml(index, premium_part));
			newRow.appendTo(`#reportTeam-inputs`);

			newRow.find('.delete-btn').on('click', function() {
				newRow.remove();
			})
		});
	});
	function getHtml(index, premium_part) {
		return `
		<tr>
			<th class="premiumPart gray d-none">Размер премиальной части проекта, руб. без НДС</th>
			<td colspan="3" class="gray d-none"><input type="text" class="form-control"
				name="roles[${index}][premium_part]" id="premium_part_${index}" value="${premium_part}"></td>
		</tr>
		<tr>
		<td class="blue"><input type="text" class="form-control" name="roles[${index}][roleFio]"
			id="roleFio" placeholder="Введите ФИО (роль в проекте)"></td>
		<td class="blue"><input type="text" class="form-control" name="roles[${index}][roleDescription]"
			id="roleDescription" placeholder="Введите расширенное описание роли"></td>
		<td><input type="text" class="form-control" name="roles[${index}][roleImpact]"
			 id="roleImpact" placeholder="Введите вклад в успех проекта, %"></td>
		<td class="gray"><input type="text" class="form-control" name="roles[${index}][roleBonus]"
			id="roleBonus" placeholder="Введите дополнительную премию, руб. без НДС"></td>
		<td><button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-times"></i></button></td></td>
	   </tr>
		`
	}
</script>
{{-- Расчет полей для добавления --}}
<script>
	function calculateFields() {
		const sum = Math.round(parseFloat($('#expenseMaterialFact').val() || 0) +
			parseFloat($('#expenseDeliveryFact').val() || 0) +
			parseFloat($('#expenseWorkFact').val() || 0) +
			parseFloat($('#expenseOtherFact').val() || 0) +
			parseFloat($('#expenseOpoxFact').val() || 0));
		const difference = Math.round(parseFloat($('#costRubW').val() || 0) - sum);
		const marginalityFact = Math.round(parseFloat($('#marginProfitFact').val() || 0) /
			parseFloat($('#costRubW').val() || 0));
		const profitPlan = (parseFloat($('#marginProfitPlan').val() || 0) - parseFloat($(
			'#expenseOpoxPlan').val() || 0));
		const profitFact = difference - parseFloat($('#expenseOpoxFact').val() || 0);
		const projProfitPlan = Math.round(parseFloat($('#profitPlan').val() || 0) / parseFloat($(
			'#costRubW').val() || 0));
		const projProfitFact = Math.round(parseFloat($('#profitFact').val() || 0) / parseFloat($(
			'#costRubW').val() || 0));

		const premium_part = Math.round(difference * 0.01);

		// Обновляем поля
		$('#expenseDirectFact').val(sum);
		$('#marginProfitFact').val(difference);
		$('#marginalityFact').val(marginalityFact);
		$('#profitPlan').val(profitPlan);
		$('#profitFact').val(profitFact);
		$('#projProfitPlan').val(projProfitPlan);
		$('#projProfitFact').val(projProfitFact);

		$('#premium_part').val(premium_part);

	}
	$(document).ready(function() {
		// Указываем, что при изменении текстовых полей нужно вызывать функцию:
		$("#expenseMaterialFact, #expenseDeliveryFact, #expenseWorkFact, #expenseOtherFact, #expenseOpoxFact, #costRubW, #expenseDirectFact, #marginProfitFact, #marginalityPlan, #expenseOpoxPlan, #expenseOpoxFact, #profitPlan, #profitFact, #premium_part")
			.on('input', calculateFields);
	});

</script>
