@extends('layouts.admin-layout')

@section('title', 'Order')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush

    <div class="card">
        <div class="card-header">
            <a href="{{ route('order.create') }}" class="btn btn-primary">Create Order</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Number</th>
                        <th>Cashier</th>
                        <th>Discount</th>
                        <th>Discount Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        </div>

    @push('scripts')
        <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <script>
            $(function () {
                $('.datatable').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('order.index') }}'
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'order_number', name: 'order_number' },
                        { data: 'cashier_name', name: 'cashier_name' },
                        { data: 'discount', name: 'discount' },
                        { data: 'discount_type', name: 'discount_type' },
                        { data: 'date', name: 'date' },
                        { data: 'status', name: 'status' },
                        { data: 'payment_method_name', name: 'payment_method_name' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ]
                })
            });

            function confirmDelete(orderId) {
                if (confirm('Delete this order?')) {
                    document.getElementById('delete-form-' + orderId).submit();
                }
            }
        </script>
    @endpush

@endsection