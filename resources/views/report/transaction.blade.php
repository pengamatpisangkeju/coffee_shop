@extends('layouts.admin-layout')

@section('title', 'Transaction Report')

@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Transaction Report</h3>
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
			<canvas id="transactionChart" width="400" height="200"></canvas>

			<div class="alert alert-primary mt-4">
				<strong>Total Profit:</strong> Rp <span id="totalProfit">{{$total_profit}}</span>
			</div>

			<table class="table table-bordered mt-4" id="ordersTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Cashier</th>
						<th>Date</th>
						<th>Payment Method</th>
						<th>Total Price</th>
						<th>Total Profit</th>
					</tr>
				</thead>
				<tbody>
					@foreach($orders as $order)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $order->cashier->name }}</td>
										<td>{{ $order->date }}</td>
										<td>{{ $order->paymentMethod->method }}</td>
										<td>Rp
											{{ number_format($order->orderDetail->sum(function ($detail) {
							return $detail->selling_price * $detail->qty;
						}), 2, ',', '.') }}
										</td>
										<td>Rp
											{{ number_format($order->orderDetail->sum(function ($detail) {
							return ($detail->selling_price - $detail->capital_price) * $detail->qty;
						}), 2, ',', '.') }}
										</td>
									</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	@push('scripts')
		<script>
			$(document).ready(function () {
				var ctx = document.getElementById('transactionChart').getContext('2d');
				var transactionChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: {!! json_encode($labels) !!},
						datasets: [{
							label: 'Total Transactions',
							data: {!! json_encode($data) !!},
							backgroundColor: 'rgba(54, 162, 235, 0.2)',
							borderColor: 'rgba(54, 162, 235, 1)',
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					}
				});

				$('#filter').click(function () {
					var period = $('#period').val();
					var month = $('#month').val();
					var year = $('#year').val();

					$.ajax({
						url: '{{ route('report.transaction') }}',
						type: 'GET',
						data: { period: period, month: month, year: year },
						success: function (response) {
							transactionChart.data.labels = response.labels;
							transactionChart.data.datasets[0].data = response.data;
							transactionChart.update();

							var tableBody = '';
							response.orders.forEach(function (order, index) {
								tableBody += `
													<tr>
														<td>${index + 1}</td>
														<td>${order.cashier.name}</td>
														<td>${order.date}</td>
														<td>${order.payment_method.method}</td>
														<td>Rp ${order.total_price}</td>
														<td>Rp ${order.total_profit}</td>
													</tr>
												`;
							});
							$('#ordersTable tbody').html(tableBody);

							$('#totalProfit').text(response.total_profit);
						}
					});
				});
			});
		</script>
	@endpush
@endsection