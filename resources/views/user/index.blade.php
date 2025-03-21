@extends('layouts.admin-layout')

@section('title', 'User')

@section('content')
	@push('styles')
		<!-- DataTables -->
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	@endpush

	<div class="card">
	<div class="card-header">
			<a href="{{ route('user.create') }}" class="btn btn-primary">Create User</a>
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
						<th>Email</th>
						<th>Role</th>
						<th>Image</th>
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
						url: '{{ route('user.index') }}'
					},
					columns: [
						{ data: 'DT_RowIndex', orderable: false, searchable: false },
						{ data: 'name' },
						{ data: 'email' },
						{
							data: 'role',
							render: function (data) {
								return data.charAt(0).toUpperCase() + data.slice(1)
							}
						},
						{
							data: 'image_path',
							orderable: false,
							searchable: false,
							render: function (data) {
								if (data) {
									return '<img src="{{ asset('storage/') }}/' + data + '" style="width: 50px; height: 50px; object-fit: cover;">';
								} else {
									return 'No Image';
								}
							},
						},
						{
							data: 'action',
							orderable: false,
							searchable: false,
						},
					]
				});
			});

			function confirmDelete(userId) {
				if (confirm('Delete this user?')) {
					document.getElementById('delete-user-' + userId).submit();
				}
			}
		</script>
	@endpush
@endsection