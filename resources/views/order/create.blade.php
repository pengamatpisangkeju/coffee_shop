@extends('layouts.admin-layout')

@section('title', 'Create Order')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New Order</h3>
        </div>
        <form action="{{ route('order.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="cashier_id">Cashier</label>
                    <select name="cashier_id" id="cashier_id" class="form-control">
                        @foreach($cashiers as $cashier)
                            <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Items</label>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#itemModal">
                        Search Items
                    </button>
                    <table class="table table-bordered table-striped" id="selectedItemsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Capital Price</th>
                                <th>Selling Price</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <input type="hidden" name="items" id="selectedItemsInput">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="itemModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Select Items</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped datatable" id="itemsDataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Qty Selected</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('.datatable').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('item.index') }}'
                    },
                    columns: [
                        { data: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name' },
                        { data: 'price', searchable: false },
                        { data: 'qty', searchable: false },
                        {
                            data: null,
                            render: function (data, type, row) {
                                return '<input type="number" class="itemQty" value="1" min="1" data-id="' + row.id + '">';
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                return '<button type="button" class="btn btn-success btn-sm selectItemBtn" data-id="' + row.id + '" data-name="' + row.name + '" data-capital-price="' + row.capital_price + '" data-selling-price="' + row.selling_price + '">Select</button>';
                            }
                        }
                    ]
                });

                let selectedItems = {};
                
                $(document).on('click', '.selectItemBtn', function () {
                    let itemId = $(this).data('id')
                    let itemName = $(this).data('name')
                    let itemCapitalPrice = $(this).data('capital-price')
                    let itemSellingPrice = $(this).data('selling-price')
                    let itemQty = parseInt($('.itemQty[data-id="' + itemId + '"]').val())

                    if (selectedItems[itemId]) {
                        selectedItems[itemId].qty += itemQty
                    } else {
                        selectedItems[itemId] = {
                            id: itemId,
                            name: itemName,
                            capitalPrice: itemCapitalPrice,
                            sellingPrice: itemSellingPrice,
                            qty: itemQty,
                        }
                    }

                    updateSelectedItemsTable()
                });

                function updateSelectedItemsTable() {
                    
                }


            });
        </script>
    @endpush
@endsection