@extends('layouts.admin-layout')

@section('title', 'Create Order')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Create New Order</h3>
		</div>

		<form action="{{ route('order.store') }}" method="post">
			@csrf
			<div class="card-body">
				@if(session('error'))
					<div class="alert alert-danger">
						{{ session('error') }}
					</div>
				@endif
				<div class="form-group">
					<label>Items</label>
					<div class="mb-2">
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#itemModal">
							Search Items
						</button>
					</div>
					<table class="table table-bordered table-striped" id="selectedItemsTable">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<div id="selectedItemsInputContainer"></div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="discount">Discount</label>
							<input type="number" name="discount" id="discount" class="form-control" value="0">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="discount_type">Discount Type</label>
							<select name="discount_type" id="discount_type" class="form-control">
								<option value="percentage">Percentage (%)</option>
								<option value="amount">Amount (Rp)</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="payment_methodp_id">Payment Method</label>
							<select name="payment_method_id" id="payment_method_id" class="form-control">
								@foreach ($paymentMethods as $paymentMethod)
									<option value="{{ $paymentMethod->id }}">{{ ucfirst($paymentMethod->method) }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Total</label>
					<input type="text" id="totalPrice" class="form-control" readonly>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>

	<div class="modal fade" id="itemModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="itemModalLabel">Select Items</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body" style="overflow-x: auto;">
					<table class="table table-bordered table-striped datatable" id="itemsDataTable" style="min-width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Qty Selected</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	@push('styles')
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	@endpush

	@push('scripts')
		<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
		<script>
			$(document).ready(function () {
				$('.datatable').DataTable({
					serverSide: true,
					processing: true,
					ajax: {
						url: '{{ route('item.index') }}'
					},
					columns: [
						{ data: 'DT_RowIndex', orderable: false, searchable: false },
						{ data: 'name' },
						{
							data: 'selling_price',
							searchable: false,
							render: function (data) {
								return 'Rp' + parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
							},
						},
						{ data: 'qty', searchable: false },
						{
							data: null,
							render: function (data, type, row) {
								return '<input type="number" class="itemQty" value="1" min="1" data-id="' + row.id + '">';
							}
						},
						{
							data: null,
							render: function (data, type, row) {
								return '<button type="button" class="btn btn-success btn-sm selectItemBtn" data-id="' + row.id + '" data-name="' + row.name + '" data-capital-price="' + row.capital_price + '" data-selling-price="' + row.selling_price + '">Select</button>';
							}
						}
					]
				});

				let selectedItems = {};
				const selectedItemsTable = $('#selectedItemsTable').DataTable({
					columns: [
						{ data: null, render: function (data, type, row, meta) { return meta.row + 1; } },
						{ data: 'name' },
						{
							data: 'selling_price',
							render: function (data) {
								return 'Rp' + parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
							},
						},
						{ data: 'qty' },
						{
							data: null,
							render: function (data, type, row) {
								return '<button type="button" class="btn btn-danger btn-sm removeItemBtn" data-id="' + row.id + '">Remove</button>';
							}
						}
					],
					data: [],
					paging: true,
					searching: true,
					info: false
				});

				$(document).on('click', '.selectItemBtn', function () {
					const itemId = $(this).data('id');
					const itemName = $(this).data('name');
					const itemSellingPrice = parseFloat($(this).data('selling-price'));
					const itemQty = parseInt($('.itemQty[data-id="' + itemId + '"]').val());

					if (selectedItems[itemId]) {
						selectedItems[itemId].qty += itemQty;
					} else {
						selectedItems[itemId] = {
							id: itemId,
							name: itemName,
							selling_price: itemSellingPrice,
							qty: itemQty,
						};
					}

					updateSelectedItemsTable();
				});

				$(document).on('click', '.removeItemBtn', function () {
					let itemId = $(this).data('id');
					delete selectedItems[itemId];
					updateSelectedItemsTable();
				});

				function updateSelectedItemsTable() {
					const selectedItemsArray = Object.values(selectedItems);
					const selectedItemsIdArray = Object.keys(selectedItems);
					selectedItemsTable.clear().rows.add(selectedItemsArray).draw();

					$('#selectedItemsInputContainer').empty();
					selectedItemsIdArray.forEach(itemId => {
						$('#selectedItemsInputContainer').append(
							`<input type="hidden" name="item_id[]" value="${itemId}">`
						);
					});
					calculateTotal();
				}

				function calculateTotal() {
					let total = 0;
					const selectedItemsArray = Object.values(selectedItems);
					selectedItemsArray.forEach(item => {
						total += item.selling_price * item.qty;
					});

					let discount = parseFloat($('#discount').val());
					let discountType = $('#discount_type').val();

					if (discountType === 'percentage') {
						total -= (total * discount) / 100;
					} else {
						total -= discount;
					}

					$('#totalPrice').val('Rp' + total.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
				}

				$(document).on('change', '#discount, #discount_type', calculateTotal);
			});
		</script>
	@endpush
@endsection