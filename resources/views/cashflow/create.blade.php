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
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                        </div>
                        @error('title')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" name="nominal" class="form-control" id="nominal"
                                placeholder="Enter nominal">
                        </div>
                        @error('nominal')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="desc" rows="3" placeholder="Enter description"></textarea>
                    @error('desc')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" class="form-control" id="type">
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        @error('type')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" id="date">
                        </div>
                        @error('date')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection