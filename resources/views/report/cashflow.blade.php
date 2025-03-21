@extends('layouts.admin-layout')

@section('title', 'Cashflow Report')

@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Cashflow Report</h3>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label>Select Period:</label>
				<select id="period" class="form-control">
					<option value="monthly" selected>Monthly</option>
					<option value="yearly">Yearly</option>
				</select>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<label for="month">Month:</label>
						<select id="month" class="form-control">
							<option value="">--Select Month--</option>
							@for ($i = 1; $i <= 12; $i++)
								<option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
							@endfor
						</select>
					</div>
					<div class="col-md-6">
						<label for="year">Year:</label>
						<input type="number" id="year" class="form-control" value="{{ date('Y') }}" placeholder="Year">
					</div>
					<div class="col-md-12 mt-2">
						<button id="filter" class="btn btn-primary">Filter</button>
					</div>
				</div>
			</div>
			<canvas id="cashflowChart" width="400" height="200"></canvas>

			<!-- Display Total Income and Expense -->
			<div class="alert alert-success mt-4">
				<strong>Total Income:</strong> Rp <span id="totalIncome">{{ $totalIncome }}</span>
			</div>
			<div class="alert alert-danger mt-2">
				<strong>Total Expense:</strong> Rp <span id="totalExpense">{{ $totalExpense }}</span>
			</div>

			<table class="table table-bordered mt-4" id="cashflowTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Description</th>
						<th>Nominal</th>
						<th>Type</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($cashflows as $cashflow)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $cashflow->title }}</td>
							<td>{{ $cashflow->desc }}</td>
							<td>Rp {{ number_format($cashflow->nominal, 2, ',', '.') }}</td>
							<td>{{ ucfirst($cashflow->type) }}</td>
							<td>{{ $cashflow->date }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	@push('scripts')
		<script>
			$(document).ready(function () {
				// Initialize Chart
				var ctx = document.getElementById('cashflowChart').getContext('2d');
				var cashflowChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: {!! json_encode($labels) !!},
						datasets: [
							{
								label: 'Income',
								data: {!! json_encode($dataIncome) !!},
								backgroundColor: 'rgba(75, 192, 192, 0.2)',
								borderColor: 'rgba(75, 192, 192, 1)',
								borderWidth: 1
							},
							{
								label: 'Expense',
								data: {!! json_encode($dataExpense) !!},
								backgroundColor: 'rgba(255, 99, 132, 0.2)',
								borderColor: 'rgba(255, 99, 132, 1)',
								borderWidth: 1
							}
						]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					}
				});

				// Filter button click event
				$('#filter').click(function () {
					var period = $('#period').val();
					var month = $('#month').val();
					var year = $('#year').val();

					$.ajax({
						url: '{{ route('report.cashflow') }}',
						type: 'GET',
						data: { period: period, month: month, year: year },
						success: function (response) {
							// Update chart data
							cashflowChart.data.labels = response.labels;
							cashflowChart.data.datasets[0].data = response.dataIncome;
							cashflowChart.data.datasets[1].data = response.dataExpense;
							cashflowChart.update();

							// Update total income and expense
							$('#totalIncome').text(response.totalIncome);
							$('#totalExpense').text(response.totalExpense);

							// Reload table content
							var tableBody = '';
							response.cashflows.forEach(function (cashflow, index) {
								tableBody += `
											<tr>
												<td>${index + 1}</td>
												<td>${cashflow.title}</td>
												<td>${cashflow.desc}</td>
												<td>Rp ${cashflow.nominal.toLocaleString('id-ID', { minimumFractionDigits: 2 })}</td>
												<td>${cashflow.type.charAt(0).toUpperCase() + cashflow.type.slice(1)}</td>
												<td>${cashflow.date}</td>
											</tr>
										`;
							});
							$('#cashflowTable tbody').html(tableBody);
						}
					});
				});
			});
		</script>
	@endpush
@endsection