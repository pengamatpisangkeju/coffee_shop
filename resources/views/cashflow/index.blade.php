@extends('layouts.admin-layout')

@section('title', 'Cashflow')

@section('content')
	@push('styles')
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	@endpush

	<div class="card">
		<div class="card-header">
			<a href="{{ route('cashflow.create') }}" class="btn btn-primary">Create Cashflow</a>
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
						<th>Title</th>
						<th>Description</th>
						<th>Nominal</th>
						<th>Type</th>
						<th>Date</th>
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
						url: '{{ route('cashflow.index') }}'
					},
					columns: [
						{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
						{ data: 'title', name: 'title' },
						{ data: 'desc', name: 'desc' },
						{ data: 'nominal', name: 'nominal', searchable: false },
						{ data: 'type', name: 'type', searchable: false },
						{ data: 'date', name: 'date', searchable: false },
						{ data: 'action', name: 'action', orderable: false, searchable: false },
					],
					order: [[5, 'desc']] // Order by Date descending
				});
			});

			function confirmDelete(cashflowId) {
				if (confirm('Delete this cashflow?')) {
					document.getElementById('delete-form-' + cashflowId).submit();
				}
			}
		</script>
	@endpush

@endsection