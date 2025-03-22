@extends('layouts.admin-layout')

@section('title', 'Edit Member')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Edit Member</h3>
		</div>
		<form action="{{ route('member.update', $member->id) }}" method="post" enctype="multipart/form-data">
			@csrf
			@method('put')
			<div class="card-body">
				<!-- Field dari tabel users -->
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" value="{{ $member->user->email }}"
						class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" required>
					@error('email')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="form-group">
					<label for="password">Password (Leave blank to keep current password)</label>
					<input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
						id="password" placeholder="Enter new password">
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
				@if ($member->user->image_path)
					<div id="currentImagePreview">
						<p>Current Image</p>
						<img src="{{ asset('storage/' . $member->user->image_path) }}" alt="Current Image"
							style="max-width: 200px; max-height: 200px;">
					</div>
				@endif
				<div id="updatedImagePreview" style="display: none;">
					<p>Image Preview</p>
					<img id="previewImage" src="#" alt="Preview Image" style="max-width: 200px; max-height: 200px;">
				</div>

				<!-- Field dari tabel members -->
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" value="{{ $member->name }}"
						class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" required>
					@error('name')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="form-group">
					<label for="phone_number">Phone Number</label>
					<input type="text" name="phone_number" value="{{ $member->phone_number }}"
						class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
						placeholder="Enter phone number" required>
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

				$('#image').change(function () {
					let reader = new FileReader();

					reader.onload = (e) => {
						$('#previewImage').attr('src', e.target.result);
						$('#updatedImagePreview').show();
						$('#currentImagePreview').hide();
					}

					reader.readAsDataURL(this.files[0]);
				});
			});
		</script>
	@endpush
@endsection