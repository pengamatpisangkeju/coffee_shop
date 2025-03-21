@extends('layouts.admin-layout')

@section('title', 'Edit Payment Method')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Edit Payment Method</h3>
		</div>
		<form action="{{ route('payment-method.update', $paymentMethod->id) }}" method="post">
			@csrf
			@method('put')
			<div class="card-body">
				<div class="form-group">
					<label for="method">Method</label>
					<input type="text" name="method" value="{{ $paymentMethod->method }}"
						class="form-control @error('method') is-invalid @enderror" id="method" placeholder="Enter method name"
						required>
					@error('method')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
@endsection