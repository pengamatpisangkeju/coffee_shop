@extends('layouts.admin-layout')

@section('title', 'Cashier Dashboard')

@section('content')
@push('styles')
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet"
		href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- JQVMap -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

<div class="row">
	<!-- Total Orders Today -->
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>{{ $totalOrdersToday }}</h3>
				<p>Total Orders Today</p>
			</div>
			<div class="icon">
				<i class="ion ion-bag"></i>
			</div>
		</div>
	</div>

	<!-- Total Revenue Today -->
	<div class="col-lg-3 col-6">
		<div class="small-box bg-success">
			<div class="inner">
				<h3>Rp {{ number_format($totalRevenueToday, 0, ',', '.') }}</h3>
				<p>Total Revenue Today</p>
			</div>
			<div class="icon">
				<i class="ion ion-cash"></i>
			</div>
		</div>
	</div>
</div>
@push('scripts')
		<!-- ChartJS -->
		<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>
@endpush
@endsection