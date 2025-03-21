@extends('layouts.admin-layout')

@section('title', 'Edit Cashflow')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Edit Cashflow</h3>
		</div>
		<form action="{{ route('cashflow.update', $cashflow->id) }}" method="post">
			@csrf
			@method('put')
			<div class="card-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" value="{{ $cashflow->title }}"
								class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title" required>
							@error('title')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="nominal">Nominal</label>
							<input type="number" name="nominal" value="{{ $cashflow->nominal }}"
								class="form-control @error('nominal') is-invalid @enderror" id="nominal" placeholder="Enter nominal"
								required>
							@error('nominal')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control @error('desc') is-invalid @enderror" name="desc" rows="3"
						placeholder="Enter description" required>{{ $cashflow->desc }}</textarea>
					@error('desc')
						<p class="text-danger">{{ $message }}</p>
					@enderror
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="type">Type</label>
							<select name="type" class="form-control @error('type') is-invalid @enderror" id="type" required>
								<option value="income" {{ $cashflow->type == 'income' ? 'selected' : '' }}>Income</option>
								<option value="expense" {{ $cashflow->type == 'expense' ? 'selected' : '' }}>Expense</option>
							</select>
							@error('type')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="date">Date (YYYY-MM-DD)</label>
							<input type="date" name="date" value="{{ date('Y-m-d', strtotime($cashflow->date)) }}"
								class="form-control @error('date') is-invalid @enderror" id="date" required>
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