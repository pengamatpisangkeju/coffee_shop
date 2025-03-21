@extends('layouts.admin-layout')

@section('title', 'Order Detail')

@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Order Detail</h3>
		</div>
		<div class="card-body">
			<h4>Order Information</h4>
			<table class="table table-bordered mb-2">
				<tr>
					<th>Cashier</th>
					<td>{{ $order->cashier->name }}</td>
				</tr>
				<tr>
					<th>Discount</th>
					<td>
						@if ($order->discount_type === 'percentage')
							{{ $order->discount }}%
						@else
							Rp {{ number_format($order->discount, 2, ',', '.') }}
						@endif
					</td>
				</tr>
				<tr>
					<th>Date</th>
					<td>{{ $order->date }}</td>
				</tr>
				<tr>
					<th>Payment Method</th>
					<td>{{ $order->paymentMethod->method }}</td>
				</tr>
			</table>

			<h4>Order Items</h4>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Item Name</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody>
					@foreach($order->orderDetail as $detail)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $detail->item->name }}</td>
							<td>Rp {{ number_format($detail->selling_price, 2, ',', '.') }}</td>
							<td>{{ $detail->qty }}</td>
							<td>Rp {{ number_format($detail->selling_price * $detail->qty, 2, ',', '.') }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
						<td>Rp
							{{ number_format($order->orderDetail->sum(function ($detail) {
		return $detail->selling_price * $detail->qty; }), 2, ',', '.') }}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
@endsection