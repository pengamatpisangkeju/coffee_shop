@extends('layouts.admin-layout')

@section('title', 'Create Item Supply')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New Item Supply</h3>
        </div>
        <form action="{{ route('item-supply.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Item</label>
                    <select name="item_id" class="form-control select2" style="width: 100%;">
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="number" name="qty" class="form-control" id="qty" placeholder="Enter quantity">
                    @error('qty')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endpush