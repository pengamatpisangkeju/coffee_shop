@extends('layouts.admin-layout')

@section('title', 'Item')

@section('content')
  @push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  @endpush

  <div class="card">
    <div class="card-body">
    <table class="table table-bordered table-striped datatable">
      <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Capital Price</th>
        <th>Selling Price</th>
        <th>Qty</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
      </thead>
    </table>
    </div>
    <!-- /.card-body -->
  </div>

  @push('scripts')
    <!-- DataTables  & Plugins -->
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
    <!-- Page specific script -->
    <script>
    $(function () {
    $('.datatable').DataTable({
      serverSide: true,
      processing: true,
      ajax: {
      url: '{{ route('item.index') }}'
      },
      columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'capital_price', name: 'capital_price' },
      { data: 'selling_price', name: 'selling_price' },
      { data: 'qty', name: 'qty' },
      { data: 'image', name: 'image' },
      { data: 'action', name: 'action' },
      ]
    })
    });
    </script>
  @endpush

@endsection