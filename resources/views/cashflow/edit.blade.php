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
                            <input type="text" name="title" value="{{ $cashflow->title }}" class="form-control" id="title"
                                placeholder="Enter title">
                        </div>
                        @error('title')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" name="nominal" value="{{ $cashflow->nominal }}" class="form-control"
                                id="nominal" placeholder="Enter nominal">
                        </div>
                        @error('nominal')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="desc" rows="3"
                        placeholder="Enter description">{{ $cashflow->desc }}</textarea>
                    @error('desc')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" class="form-control" id="type">
                                <option value="income" {{ $cashflow->type == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ $cashflow->type == 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                        </div>
                        @error('type')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="date">Date (YYYY-MM-DD)</label>
                            <input type="date" name="date" value="{{ date('Y-m-d', strtotime($cashflow->date)) }}"
                                class="form-control" id="date">
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