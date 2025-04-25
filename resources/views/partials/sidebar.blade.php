<?php
$userData = match (Auth::user()->role) {
	'owner' => Auth::user()->owner,
	'manager' => Auth::user()->manager,
	'cashier' => Auth::user()->cashier,
	'member' => Auth::user()->member,
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="{{ route('dashboard') }}" class="brand-link">
		<img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
			class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Coffee Shop</span>
	</a>

	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				@if (Auth::user()->image_path)
					<img src="{{ asset('storage/' . Auth::user()->image_path) }}" class="img-circle elevation-2" style="width:32px; height: 32px; object-fit: cover;" alt="User Image">
				@else
					<img src="{{ asset('adminlte/dist/img/boxed-bg.jpg') }}" class="img-circle elevation-2" style="width:32px; height: 32px; object-fit: cover;" alt="User Image">
				@endif
			</div>
			<div class="info">
			</div>
		</div>
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-link">
						<i class="nav-icon fas fa-chart-pie"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				@if (Auth::user()->role == 'owner')
					@include('partials.sidebar.owner')
				@elseif (Auth::user()->role == 'manager')
					@include('partials.sidebar.manager')
				@elseif (Auth::user()->role == 'cashier')
					@include('partials.sidebar.cashier')
				@elseif (Auth::user()->role == 'member')
					@include('partials.sidebar.member')
				@endif
			</ul>
		</nav>
	</div>
</aside>