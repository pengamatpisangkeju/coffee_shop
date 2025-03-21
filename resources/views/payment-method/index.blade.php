@extends('layouts.admin-layout')

@section('title', 'Payment Method')

@section('content')
	@push('styles')
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	@endpush

	<div class="card">
		<div class="card-header">
			<a href="{{ route('payment-method.create') }}" class="btn btn-primary">Create Payment Method</a>
		</div>
		<div class="card-body">
			@if(session('error'))
				<div class="alert alert-danger">
					{{ session('error') }}
				</div>
			@endif
			@if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif
			<table class="table table-bordered table-striped datatable">
				<thead>
					<tr>
						<th>#</th>
						<th>Method</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	@push('scripts')
		<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
		<script>
			$(function () {
				$('.datatable').DataTable({
					serverSide: true,
					processing: true,
					ajax: {
						url: '{{ route('payment-method.index') }}'
					},
					columns: [
						{ data: 'DT_RowIndex', orderable: false, searchable: false },
						{ data: 'method' },
						{ data: 'action', orderable: false, searchable: false },
					]
				});
			});

			function confirmDelete(paymentmethodId) {
				if (confirm('Delete this payment method?')) {
					document.getElementById('delete-payment-method-' + paymentmethodId).submit();
				}
			}
		</script>
	@endpush
@endsection