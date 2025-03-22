@extends('layouts.admin-layout')

@section('title', 'Create Member')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Create New Member</h3>
		</div>
		<form action="{{ route('member.store') }}" method="post" enctype="multipart/form-data">
			@csrf
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
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
						placeholder="Enter email" required>
					@error('email')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
						id="password" placeholder="Enter password" required>
					@error('password')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="form-group">
					<label for="image">Profile Image</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image">
							<label class="custom-file-label" for="image">Choose file</label>
						</div>
						<div class="input-group-append">
							<span class="input-group-text">Upload</span>
						</div>
					</div>
					@error('image')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>

				<!-- Field dari tabel members -->
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
						placeholder="Enter name" required>
					@error('name')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="form-group">
					<label for="phone_number">Phone Number</label>
					<input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
						id="phone_number" placeholder="Enter phone number" required>
					@error('phone_number')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>

	@push('scripts')
		<script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
		<script>
			$(function () {
				bsCustomFileInput.init();
			});
		</script>
	@endpush
@endsection