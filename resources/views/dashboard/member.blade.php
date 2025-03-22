@extends('layouts.admin-layout')

@section('title', 'Member Dashboard')

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
@push('scripts')
		<!-- ChartJS -->
		<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>
@endpush
@endsection