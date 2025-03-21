@extends('layouts.admin-layout')

@section('title', 'Create Cashflow')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Create New Cashflow</h3>
		</div>
		<form action="{{ route('cashflow.store') }}" method="post">
			@csrf
			<div class="card-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
								placeholder="Enter title" required>
							@error('title')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="nominal">Nominal</label>
							<input type="number" name="nominal" class="form-control @error('nominal') is-invalid @enderror" id="nominal"
								placeholder="Enter nominal" required>
							@error('nominal')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control @error('desc') is-invalid @enderror" name="desc" rows="3"
						placeholder="Enter description" required></textarea>
					@error('desc')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="type">Type</label>
							<select name="type" class="form-control @error('type') is-invalid @enderror" id="type" required>
								<option value="income">Income</option>
								<option value="expense">Expense</option>
							</select>
							@error('type')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="date">Date</label>
							<input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" required>
							@error('date')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
@endsection