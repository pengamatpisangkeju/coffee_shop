@extends('layouts.admin-layout')

@section('title', 'Create Item')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Create New Item</h3>
		</div>
		<form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
						placeholder="Enter name">
					@error('name')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control @error('desc') is-invalid @enderror" name="desc" rows="3"
						placeholder="Enter description"></textarea>
					@error('desc')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="capitalPrice">Capital Price</label>
							<input type="number" name="capital_price" class="form-control @error('capital_price') is-invalid @enderror"
								id="capitalPrice" placeholder="Enter capital price">
							@error('capital_price')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="sellingPrice">Selling Price</label>
							<input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror"
								id="sellingPrice" placeholder="Enter selling price">
							@error('selling_price')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="image">Image</label>
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
				<div id="updatedImagePreview" style="display: none;">
					<p>Image Preview</p>
					<img id="previewImage" src="#" alt="Preview Image" style="max-width: 200px; max-height: 200px;">
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
					}

					reader.readAsDataURL(this.files[0]);
				});
			});
		</script>
	@endpush
@endsection