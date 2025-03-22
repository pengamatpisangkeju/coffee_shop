@extends('layouts.admin-layout')

@section('title', 'Member')

@section('content')
	@push('styles')
		<!-- DataTables -->
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	@endpush

	<div class="card">
		<div class="card-header">
			<a href="{{ route('member.create') }}" class="btn btn-primary">Create Member</a>
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
						<th>Name</th>
						<th>Phone Number</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
		<!-- /.card-body -->
	</div>

	@push('scripts')
		<!-- DataTables  & Plugins -->
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
		<!-- Page specific script -->
		<script>
			$(function () {
				$('.datatable').DataTable({
					serverSide: true,
					processing: true,
					ajax: {
						url: '{{ route('member.index') }}'
					},
					columns: [
						{ data: 'DT_RowIndex', orderable: false, searchable: false },
						{ data: 'name' },
						{ data: 'phone_number' },
						{ data: 'action', orderable: false, searchable: false },
					]
				});
			});

			function confirmDelete(memberId) {
				if (confirm('Delete this member?')) {
					document.getElementById('delete-member-' + memberId).submit();
				}
			}
		</script>
	@endpush

@endsection