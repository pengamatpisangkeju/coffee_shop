@extends('layouts.admin-layout')

@section('title', 'Create Pengajuan')

@section('content')
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Create New Pengajuan</h3>
		</div>
		<form action="{{ route('pengajuan.store') }}" method="post">
			@csrf
			<div class="card-body">
				<!-- Field untuk nama barang -->
				<div class="form-group">
					<label for="nama_barang">Nama Barang</label>
					<input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
						id="nama_barang" placeholder="Enter nama barang" required>
					@error('nama_barang')
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